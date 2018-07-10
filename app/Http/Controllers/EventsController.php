<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Libraries\Vec2;
use App\Libraries\OctopathHelper;

///////////////////////////////////////////////////////////
//*-- go for it strategy from midnight me;) --*//
///////////////////////////////////////////////////////////
// 1. get user-determined range of events with UNIX timestamp conversion on it and store them in an array (a1).
// 2. create an array (a2) that represents all the possible options of the scheduling event (UNIX timestamped).
// 3. run collision detection with each elements of a1 and a2.
// pseudo-code
// foreach(a2){
//   var collided = false;
//   foreach(a1){
//       if a2.item.Collide(a1.item)
//          collided = true;
//          break;
//       endif
//   }
//   if !collided
//      print "a2.item is schedulable!";
//   endif
// }

class EventsController extends Controller
{
    function create(){
        return view('events.create');
    }
    
    function generateEvent(Request $request){
        $table = new Event();

        $table->dateTimeFromSelf = $request->dateFrom + " " + $request->timeFrom;
        $table->dateTimeToSelf = $request->dateTo + " " + $request->timeTo;
        $table->title = $request->title;
        $table->fixed = true;
        $table->eventPath = OctopathHelper::generate_octopath();

        $table->save();
    }
    
    function generateEventFromArg($dateTimeFrom, $dateTimeTo, $title){
        $table = new Event();
        
        $table->dateTimeFromSelf = $dateTimeFrom;
        $table->dateTimeToSelf = $dateTimeTo;
        $table->title = $title;
        $table->fixed = true;
        $table->eventPath = OctopathHelper::generate_octopath();

        $table->save();
    }
    
    function getFakeUsersEvents($num){
        if($num < 0) $num = 1;
        
        $users = [];
        for($i=0; $i<$num; $i++){
            $tmp = ['userId'=>$i, 'events'=>Event::all()->where('id', 1)];
            array_push($users, $tmp);
        }
        
        return $users;
    }
    
    // can't handle event that goes across with this algorithm
    function scheduleEvents(Request $request){//$req){
        //*-- event you wanna schedule --*//
        $schedulingEvent = new Event();
        $schedulingEvent->dateFrom = $request->dateFrom;
        $schedulingEvent->dateTo = $request->dateTo;
        $schedulingEvent->timeFrom = $request->timeFrom;
        $schedulingEvent->timeTo = $request->timeTo;
        
        // split each day&time options to an array
        $schedulingEvents = [];
        $formattedFrom = new \DateTime($schedulingEvent->dateFrom);
        $formattedTo = new \DateTime($schedulingEvent->dateTo);
        $daysDiff = $formattedFrom->diff($formattedTo)->days;
        for($i=0; $i<$daysDiff+1; $i++){
            $schedulingEvent_ = clone $schedulingEvent;
            $tmp = new \DateTime($schedulingEvent_->dateFrom);
            $tmp->add(new \DateInterval("P".$i."D")); //add 1 day
            $schedulingEvent_->dateFrom = $tmp->format('Y-m-d');
            
            $event = new Event();
            $event->dateFrom = $schedulingEvent_->dateFrom;
            $event->dateTo = $schedulingEvent_->dateFrom;
            $event->timeFrom = $schedulingEvent_->timeFrom;
            $event->timeTo = $schedulingEvent_->timeTo;
            array_push($schedulingEvents, $event);
        }
        
        //*-- get events of each users --*//
        $userEvents = $this->getFakeUsersEvents(5);

        //*-- get available dates for each users *--//
        $availableDatesPerUser = [];
        foreach($userEvents as $userEvent){
            $res = $this->getAvailableDates($userEvent['events'], $schedulingEvents);
            array_push($availableDatesPerUser, $res);
        }

        return view('events.result', [
            'availableDates' => $availableDatesPerUser,
        ]);
    }
    
    //compare available dates of each users
    function compareAvailableDates($availableDatesPerUser, $schedulingEvents){
        foreach($schedulingEvents as $se){
            $seFrom = new \DateTime($se->dateFrom . " " . $se->timeFrom);
            foreach($availableDatesPerUser as $ae){
                // later...
            }
        }
    }
    
    function getAvailableDates($userEvents, $schedulingEvents){
        // array for available dates
        $availableDates = [];
        
        foreach($schedulingEvents as $sEvent){
            $collided = false;
            // get timestamped sEvent
            $sEventFromTimestamp = (new \DateTime($sEvent->dateFrom . " " . $sEvent->timeFrom))->getTimestamp();
            $sEventToTimestamp = (new \DateTime($sEvent->dateTo . " " . $sEvent->timeTo))->getTimestamp();
            foreach($userEvents as $uEvent){
                // get timestamped uEvent
                $uEventFromTimestamp = (new \DateTime($uEvent->dateTimeFromSelf))->getTimestamp();
                $uEventToTimestamp = (new \DateTime($uEvent->dateTimeToSelf))->getTimestamp();
                // detect collisions
                $res = $this->collideLines(new Vec2($sEventFromTimestamp, $sEventToTimestamp), new Vec2($uEventFromTimestamp, $uEventToTimestamp));
                if($res){ $collided = true; break; }
            }
            
            // if not collided, schedulable!
            if(!$collided){
                $from = (new \DateTime($sEvent->dateFrom . " " . $sEvent->timeFrom))->getTimestamp();
                $to = (new \DateTime($sEvent->dateTo . " " . $sEvent->timeTo))->getTimestamp();
                array_push($availableDates, ['from'=>$from, 'to'=>$to]);
            }
        }
        
        return $availableDates; //return as timestamped form
    }
    
    function collideLines(Vec2 $line, Vec2 $line2){
        $cond = $line->x < $line2->y;
        $cond2 = $line->y > $line2->x;
        if($cond && $cond2){
            return true;
        }
        return false;
    }
    
}

    // // can't handle event that goes across with this algorithm
    // function scheduleEvents(Request $request){
    //     //event you wanna insert from input form
    //     $schedulingEvent = new Event();
    //     $schedulingEvent->dateFrom = $request->dateFrom;
    //     $schedulingEvent->dateTo = $request->dateTo;
    //     $schedulingEvent->timeFrom = $request->timeFrom;
    //     $schedulingEvent->timeTo = $request->timeTo;
        
    //     // split each day&time options to an array
    //     $schedulingEvents = [];
    //     $formattedFrom = new \DateTime($eventScheduling->dateFrom);
    //     $formattedTo = new \DateTime($eventScheduling->dateTo);
    //     $daysDiff = $formattedFrom->diff($formattedTo);
    //     for($i=0; $i<$daysDiff+1; $i++){
    //         $schedulingEvent_ = clone $schedulingEvent;
    //         $tmp = new \DateTime($schedulingEvent_->dateFrom);
    //         $tmp->add(new \DateInterval("P".$i."D")); //add 1 day
    //         $schedulingEvent_->dateFrom = $tmp->format('Y-m-d');
    //         $event = new Event();
    //         $event->dateFrom = $schedulingEvent_->dateFrom;
    //         $event->dateTo = $schedulingEvent_->dateFrom;
    //         $event->timeFrom = $schedulingEvent_->timeFrom;
    //         $event->timeTo = $schedulingEvent_->timeTo;
    //         array_push($schedulingEvents, $event);
    //     }
        
    //     // get events
    //     $userEvents = Event::all();
        
    //     // var_dump($this->getAvailableDates($schedulingEvent));
    //     var_dump($this->getAvailableDates2($userEvents, $schedulingEvents));
    // }


    //*-- get all the available dates (=insertable dates) from dateFrom to dateTo --*//
    // function getAvailableDates($eventScheduling){
    //     $dateFrom2Search = new \DateTime($eventScheduling->dateFrom);
    //     $dateTo2Search = new \DateTime($eventScheduling->dateTo);
    //     $dateDiff2Search = $dateFrom2Search->diff($dateTo2Search)->days;

    //     $availableDates = [];
    //     for($i=0; $i<$dateDiff2Search+1; $i++){
    //         $dateFrom2Search_ = clone $dateFrom2Search; //clone dateFrom2Search to avoid reference parse
    //         $dateFrom2Search_->add(new \DateInterval("P".$i."D")); //move to next day
    //         $dateFrom2SearchFormatted = $dateFrom2Search_->format('Y-m-d'); //format to manipulating-friendly
    //         // echo "i:$i df2s:$dateFrom2SearchFormatted, ";
    //         $events = Event::where('dateFrom', '=', $dateFrom2SearchFormatted)->get(); //get events starting on the same date
            
    //         //determine if $event is insertable(=$available) somewhere bet $events and save to array(=$availableDates)
    //         $available = true;
    //         foreach($events as $event){
    //             $interected = $this->isIntersected($event, $eventScheduling);
    //             if($interected){
    //                 $available = false;
    //                 break;
    //             }
    //         }
    //         if($available){
    //             array_push($availableDates, $dateFrom2SearchFormatted);
    //         }
    //     }
        
    //     return $availableDates;
    // }

    // function isIntersected($event, $event2){
    //     //convert time column data to DateTime object
    //     $eventTime = ["from" => new \DateTime($event->timeFrom), "to" => new \DateTime($event->timeTo)];
    //     $event2Time = ["from" => new \DateTime($event2->timeFrom), "to" => new \DateTime($event2->timeTo)];
        
    //     //get each time length
    //     $interval = $event2Time['from']->getTimestamp() - $eventTime['from']->getTimestamp();
        
    //     $bothActualTimeLength = ($interval<0) ? 
    //         $eventTime['to']->getTimestamp() - $event2Time['from']->getTimestamp() :
    //         $event2Time['to']->getTimestamp() - $eventTime['from']->getTimestamp();
    //     $eventTimeLength = $eventTime['to']->getTimestamp() - $eventTime['from']->getTimestamp();
    //     $event2TimeLength = $event2Time['to']->getTimestamp() - $event2Time['from']->getTimestamp();
    //     $bothShortestTimeLength = $eventTimeLength + $event2TimeLength;
        
    //     // echo "both:  $bothTimeLength, ";
    //     // echo "event: $eventTimeLength, ";
    //     // echo "event2:$event2TimeLength, ";
        
    //     //if length of event to event2 is smaller than length of event and event2, intersected!
    //     return $bothActualTimeLength - $bothShortestTimeLength < 0;
    // }