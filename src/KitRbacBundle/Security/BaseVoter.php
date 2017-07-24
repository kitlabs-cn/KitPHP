<?php
namespace KitRbacBundle\Security;

use KitRbacBundle\Entity\Post;
use KitRbacBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class BaseVoter extends Voter
{
    // these strings are just invented: you can use anything
    const ADD = 'add';
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    private $decisionManager;
    
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
    
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
//         if (!in_array($attribute, array(self::ADD, self::VIEW, self::EDIT, self::DELETE))) {
//             return false;
//         }

//         // only vote on Post objects inside this voter
//         if (!$subject instanceof Post) {
//             return false;
//         }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /**
         * @var \KitRbacBundle\Entity\User
         */
        $user = $token->getUser();
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }
        // 查询access list
        // you know $subject is a Post object, thanks to supports
        // 多亏了supports，你知道 $subject 是 Post 对象
        /** @var Post $post */
//         $post = $subject;

//         switch ($attribute) {
//             case self::VIEW:
//                 return $this->canView($post, $user);
//             case self::EDIT:
//                 return $this->canEdit($post, $user);
//         }
        return true;
        throw new \LogicException('This code should not be reached!');
    }
}