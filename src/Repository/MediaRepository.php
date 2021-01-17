<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }


    // /**
    //  * @return Media[] Returns an array of Media objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function imageByArticle($article_id){
        return $this->createQueryBuilder('m')
            ->andWhere("m.article = :id" )
            ->andWhere("m.type = :img" )
            ->setParameter("id", $article_id)
            ->setParameter("img", "image")
            ->orderBy('m.ordre', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function audioByArticle($article_id){
        return $this->createQueryBuilder('m')
            ->andWhere("m.article = :id" )
            ->andWhere("m.type = :aud" )
            ->setParameter("id", $article_id)
            ->setParameter("aud", "audio")
            ->orderBy('m.ordre', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    } 
    public function videoUrlByArticle($article_id){
        return $this->createQueryBuilder('m')
            ->andWhere("m.article = :id" )
            ->andWhere("m.type = :vid" )
            ->andWhere("m.nom = :nom" )
            ->setParameter("id", $article_id)
            ->setParameter("vid", "video")
            ->setParameter("nom", "url")
            ->orderBy('m.ordre', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }  
    public function videoFichierByArticle($article_id){
        return $this->createQueryBuilder('m')
            ->andWhere("m.article = :id" )
            ->andWhere("m.type = :vid" )
            ->andWhere("m.url = :url" )
            ->setParameter("id", $article_id)
            ->setParameter("vid", "video")
            ->setParameter("url", "fichier")
            ->orderBy('m.ordre', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }        
    public function findOneMedia($media_id){
        return $this->createQueryBuilder('m')
            ->andWhere("m.id = :id" )
            ->setParameter("id", $media_id)
            ->getQuery()
            ->getResult()
            ;
    }
      
    /*
    public function findOneBySomeField($value): ?Media
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
