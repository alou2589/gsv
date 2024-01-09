<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{   

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $roles = [
            'ROLE_SUPERADMIN' => 'Super Admin',
            'ROLE_ADMIN' => 'Administrateur',
        ];

        foreach ($roles as $key => $value) {
            if (!$manager->getRepository(Role::class)->findBy(['nom_role'=>$key])) {
                $role = new Role();
                $role->setNomRole($key);
                $role->setLibelle($value);
                $manager->persist($role);
                
            }
        }
        
        $user=new User();  
        $password="passe123";
        
        $user->setPrenom("administrator");
        $user->setNom("administrator");
        $user->setMatricule("000-000/Z");
        $user->setPseudo("admin");
        $user->setEmail("admin@gmail.com");
        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $password,
            )
        );
        $user->setNbConnect(0);
        $user->setRoles(['ROLE_ADMIN']);
        
        
        $manager->persist($user);
        $manager->flush();
    }
}
