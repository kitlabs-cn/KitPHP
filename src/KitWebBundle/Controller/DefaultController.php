<?php

namespace KitWebBundle\Controller;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        /**
         * 
         * @var \Symfony\Component\Stopwatch\Stopwatch $stopwatch
         */
        $stopwatch = $this->get('debug.stopwatch');
        $stopwatch->start('news', 'cate1');
        /**
         * @var $repository \KitNewsBundle\Repository\NewsRepository
         */
        $repository = $this->getDoctrine()->getRepository('KitNewsBundle:News');
        $top1 = $repository->getListPage(2, 0, 10);
        $top2 = $repository->getListPage(3, 0, 10);
        $stopwatch->lap('news');
        
        $bottom1 = $repository->getListPage(4, 0, 10);
        $bottom2 = $repository->getListPage(5, 0, 10);
        $stopwatch->lap('news');
        
        $notice = $repository->getListPage(6, 0, 10);
        $images = $repository->getListPage(null, 0, 12);
        $toutiao = $repository->getToutiao(1);
        $event = $stopwatch->stop('news');
        dump($event);
        dump($event->getCategory());   // Returns the category the event was started in
        dump($event->getOrigin());     // Returns the event start time in milliseconds
        dump($event->ensureStopped()); // Stops all periods not already stopped
        dump($event->getStartTime());  // Returns the start time of the very first period
        dump($event->getEndTime());    // Returns the end time of the very last period
        dump($event->getDuration());   // Returns the event duration, including all periods
        dump($event->getMemory());     // Returns the max memory usage of all periods
        
        return $this->render('KitWebBundle:Default:index.html.twig', [
            'nav' => 1,
            'toutiao' => $toutiao,
            'top1' => $top1,
            'top2' => $top2,
            'bottom1' => $bottom1,
            'bottom2' => $bottom2,
            'notice' => $notice,
            'images' => $images
        ]);
    }
}
