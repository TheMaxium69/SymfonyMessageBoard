<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function index(MessageRepository $msgRepo): Response
    {
        $messages = $msgRepo->findAll();
        return $this->json($messages);
    }

    /**
     * @Route("/message/create", name="messageCreate", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $manager, SerializerInterface $serializer): Response
    {
        $data = $request->getContent();
        $message = $serializer->deserialize($data, Message::class, 'json');

        $manager->persist($message);
        $manager->flush();

        return $this->json($message);
    }

    /**
     * @Route("/message/del/{id}", name="messageDel", methods={"DELETE"})
     */
    public function delete(Message $message, Request $request, EntityManagerInterface $manager): Response
    {
        $manager->remove($message);
        $manager->flush();

        return $this->json("OK", 200, []);
    }

    /**
     * @Route("/message/edit/{id}", name="messageEdit", methods={"PATCH"})
     */
    public function edit(Message $message, Request $request, SerializerInterface $serializer, EntityManagerInterface $manager): Response
    {
        $data = $request->getContent();
        $messageEdit = $serializer->deserialize($data, Message::class, 'json');

        $message->setTitle($messageEdit->getTitle());
        $message->setContent($messageEdit->getContent());

        $manager->remove($messageEdit);
        $manager->flush();

        return $this->json($message);

    }

}
