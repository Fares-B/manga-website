<?php

namespace App\Controller\Security\Admin;

use App\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConfigTableInDatabaseController extends AbstractController
{
    private $existEntity;
    private $em;

    public function __construct(EntityManagerInterface $em) {
        // Pour éviter d'avoir des noms de table inexistant
        $this->existEntity = ['Anime', 'Episode', 'Kind', 'Status', 'Type', 'Format', 'Voice'];
        $this->em = $em;
    }
    /**
     * @Route("/admin/config/table", name="security_admin_config_table")
     */
    public function index()
    {
        $configs = [
            'Anime' => [
                'Kind',
                'Status',
                'Type',
            ],
            'Episode' => [
                'Format',
                'Voice',
            ],
        ];
        return $this->render('security/admin/config_table/index.html.twig', [
            'title' => 'Config Table In Database',
            'configs' => $configs,
        ]);
    }

    /**
     * Configure une table
     * 
     * @Route("/admin/config/table/{parent}/{classname}", name="security_admin_config_table_one")
     */
    public function configTable(Request $request)
    {
        $params = $this->getParamsUrl($request);
        // detruit l'array en 2 variables
        ['parent' => $parent, 'classname' => $className] = $params;
        // Si il n'existe pas alors pas besoin de continuer
        if (!in_array($className, $this->existEntity) || !in_array($parent, $this->existEntity)) {
            // pas de message flash
            return $this->redirectToRoute("security_admin_config_table");
        }

        // Récupére toutes les names dans la table
        $table = $this
            ->getDoctrine()
            ->getRepository($this->getRepoPath($parent, $className))
            ->findAll();

        return $this->render('security/admin/config_table/show_config.html.twig', [
            'title' => $className,
            'table' => $table,
            'parent' => $parent,
            'classname' => $className,
        ]);
    }

    /**
     * Ajoute un Item dans la table
     * @Route("/admin/config/table/{parent}/{classname}/new", name="security_admin_config_table_new_item")
     */
    public function addItemTable(Request $request)
    {
        $params = $this->getParamsUrl($request);
        ['parent' => $parent, 'classname' => $className] = $params;
        // Récupére le name de l'item du formulaire
        $name = $request->query->get('name');

        $entity = $this->getRepoPath($parent, $className);
        // Instancie un obj, donne un nom, et l'ajoute dans la bdd
        $obj = new $entity;
        $obj->setName($name);
        $this->em->persist($obj);
        $this->em->flush();

        return $this->redirectToRoute('security_admin_config_table_one', [
            'parent' => $parent,
            'classname' => $className,
        ]);
    }

    /**
     * Supprime un utilisateur ou moderateur
     * @Route("/admin/config/table/{parent}/{classname}/{id}/delete", name="security_admin_config_table_delete_item")
     */
    public function deleteItemTable(Request $request)
    {
        $params = $this->getParamsUrl($request);
        ['parent' => $parent, 'classname' => $className, 'id' => $id] = $params;

        // Récupére L'item
        $item = $this
            ->getDoctrine()
            ->getRepository($this->getRepoPath($parent, $className))
            ->findOneById($id);
        // Suprime l'item de la table
        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();
        // /admin/config/table/Episode/Voice
        return $this->redirectToRoute('security_admin_config_table_one', [
            'parent' => $parent,
            'classname' => $className,
        ]);
    }

    /**
     * Retourne les variable reçu par url
     * 
     * @return array
     */
    private function getParamsUrl($request): array
    {
        // récupére les variables dans l'url
        $params = $request->attributes->get('_route_params');
        return $params;
    }

    /**
     * Retourne le chemin de l'entité
     * 
     * @return string
     */
    private function getRepoPath($parent, $className):string
    {
        return "App\Entity\\$parent\\$className";
    }
}
