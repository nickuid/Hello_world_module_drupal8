<?php

namespace Drupal\hello_world\EventSubscriber;
   use Drupal\Core\Session\AccountProxyInterface;
   use Symfony\Component\EventDispatcher\EventSubscriberInterface;
   use Symfony\Component\HttpFoundation\RedirectResponse;
   use Symfony\Component\HttpFoundation\Request;
   use Symfony\Component\HttpKernel\Event\GetResponseEvent;
   use Symfony\Component\HttpKernel\KernelEvents;
   use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Subscribes to the Kernel Request event and redirects to the homepage
 * when the user has the "non_grata" role.
 */
class HelloWorldRedirectSubscriber implements EventSubscriberInterface {

  /**
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;
  protected $currentRouteMatch;
  /**
      * HelloWorldRedirectSubscriber constructor.
      *
      * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
      */
     public function __construct(AccountProxyInterface $currentUser, RouteMatchInterface $currentRouteMatch) {
       $this->currentUser = $currentUser;
       $this->currentRouteMatch = $currentRouteMatch;
}

 /**
      * {@inheritdoc}
      */
     public static function getSubscribedEvents() {
       $events[KernelEvents::REQUEST][] = ['onRequest', 0];
      
  
                          
        return $events;
     }

  /**
      * Handler for the kernel request event.
      *
      * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
      */
     public function onRequest(GetResponseEvent $event) {
       $route_name = $this->currentRouteMatch->getRouteName();
     

     if ($route_name !== 'hello_world.hello') {
       return;
}
     $roles = $this->currentUser->getRoles();
     if (in_array('non_grata', $roles)) {
       $url = Url::fromUri('internal:/');
       $event->setResponse(new RedirectResponse($url->toString()));
     }
}
}