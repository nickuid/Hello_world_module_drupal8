<?php
  namespace Drupal\hello_world;
  use Drupal\Core\StringTranslation\StringTranslationTrait;
  use Drupal\Core\Config\ConfigFactoryInterface;
  use Symfony\Component\EventDispatcher\EventDispatcherInterface;
   /**
    * Prepares the salutation to the world.
    */
  class HelloWorldSalutation {

    use StringTranslationTrait;
    /**
      * @var \Drupal\Core\Config\ConfigFactoryInterface
      */
     protected $configFactory;
     /**
    * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
    */
   protected $eventDispatcher;

     /**
    * HelloWorldSalutation constructor.
    *
    * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
    * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface
   $eventDispatcher
    */
   public function __construct(ConfigFactoryInterface $config_factory,
   EventDispatcherInterface $eventDispatcher) {
     $this->configFactory = $config_factory;
     $this->eventDispatcher = $eventDispatcher;
   }
    public function getSalutation() {
       $config = $this->configFactory->get('hello_world.custom_salutation');
     $salutation = $config->get('salutation');
     if ($salutation != "") {
     $event = new SalutationEvent();
     $event->setValue($salutation);
     $event = $this->eventDispatcher->dispatch(SalutationEvent::EVENT, $event);
     return $event->getValue();
}
      $time = new \DateTime();
      if ((int) $time->format('G') >= 06 && (int) $time->format('G') < 12) {
        return $this->t('Good morning people');
      }
      if ((int) $time->format('G') >= 12 && (int) $time->format('G') < 18) {
        return $this->t('Good afternoon people');
      }
      if ((int) $time->format('G') >= 18) {
        return $this->t('Good evening people');
      }
    }

    /**
      * Returns the Salutation render array.
      */
     public function getSalutationComponent() {
       $render = [
         '#theme' => 'hello_world_salutation',
       ];
       $config = $this->configFactory->get('hello_world.custom_salutation');
       $salutation = $config->get('salutation');
       if ($salutation != "") {
         $render['#salutation'] = $salutation;
         $render['#overridden'] = TRUE;
         return $render;
}
       $time = new \DateTime();
       $render['#target'] = $this->t('world');
       if ((int) $time->format('G') >= 06 && (int) $time->format('G') < 12) {
         $render['#salutation'] = $this->t('Good morning');
         return $render;
}
       if ((int) $time->format('G') >= 12 && (int) $time->format('G') < 18) {
         $render['#salutation'] = $this->t('Good afternoon');
         return $render;
       }
       if ((int) $time->format('G') >= 18) {
         $render['#salutation'] = $this->t('Good evening');
         return $render;
} }
  }
