<?php

namespace ShoppingCardBundle\Controller;

use ShoppingCardBundle\Document\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;



class DefaultController extends Controller
{


    public function indexAction(Request $request)
    {

        $searchQuery =  $request->query->get('query');
        $query = $this->get('doctrine_mongodb')
            ->getManager()
            ->createQueryBuilder('ShoppingCardBundle:Product');

        if($searchQuery){
            $query->field('name')->equals(new \MongoRegex('/.*'.$searchQuery.'.*/i'));
        }
        $query = $query->getQuery();

        /**
         * @var  $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            1
        );


        return $this->render('@ShoppingCard/Default/index.html.twig',
            array('paginator' => $result));
    }



    public function createAction(Request $request)
    {

        $product = new Product();

        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('category', TextType::class)
            ->add('price', NumberType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($product);
            $dm->flush();
        }


        return $this->render('@ShoppingCard/Default/create.html.twig', array(
            'form' => $form->createView(),));

    }


    public function editAction($id, Request $request)
    {
        $product = $this->get('doctrine_mongodb')
            ->getRepository('ShoppingCardBundle:Product')
            ->find($id);

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');

        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('category', TextType::class)
            ->add('price', NumberType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($product);
            $dm->flush();
        }
        return $this->render('@ShoppingCard/Default/edit.html.twig', array(
            'form' => $form->createView(),));
    }

    public function deleteAction($id, Request $request)
    {
        $product = $this->get('doctrine_mongodb')
            ->getRepository('ShoppingCardBundle:Product')
            ->find($id);

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->remove($product);
        $dm->flush();

        $this->addFlash(
            'notice',
            'Product Deleted!'
        );

        return $this->RedirectToRoute('product_index');
    }

}









