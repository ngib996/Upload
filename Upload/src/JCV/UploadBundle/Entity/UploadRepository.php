<?php

namespace JCV\UploadBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use JCV\UploadBundle\Entity\Activity;
use JCV\UploadBundle\Entity\Lap;
use JCV\UploadBundle\Entity\Track;
use JCV\UploadBundle\Entity\TrackPoint;


/**
 * UploadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UploadRepository extends EntityRepository
{
    public function getUploads($page = 1, $nbPerPage = 20) {
        $qb = $this->createQueryBuilder('u')
            ->addOrderBy('u.updatedAt', 'DESC');

        $qb->setFirstResult(($page - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage);


        return new Paginator($qb, true);
    }

    public function persistXml($entity) {
        $xmlFileName=$entity->getUploadDir() . "/" . $entity->getUploadFile();
        $xml = simplexml_load_file($xmlFileName);
        foreach ($xml as $key => $value) {
            if ($key == 'Activities') {
                $activities = array();
                foreach ($value as $key => $value) {
//                    echo $key ;echo "//////";echo "<br/>";
                    $activity = new Activity();
                    $activity->setUpload($entity);
                    $activity->setSport($value->attributes()['Sport']);
                    $activity->setStartTime(new \DateTime($value->Id));
//                    echo "Sport=";echo $value->attributes()['Sport'];echo "<br/>";
//                    echo "Id=";echo $value->Id;echo "<br/>";
                    $laps = array();
                    $tracks = array();
                    $trackPoints = array();
                    foreach ($value->Lap as $valueLap) {
                        $lap = new Lap();
                        $lap->setActivity($activity);
                        $lap->setStartTime(new \DateTime($valueLap->attributes()['StartTime']));
                        $lap->setSpentTime($valueLap->TotalTimeSeconds);
                        $lap->setDistance($valueLap->DistanceMeters);
                        $lap->setMaxSpeed($valueLap->MaximumSpeed);
                        $lap->setAvgHr($valueLap->AverageHeartRateBpm->Value);
                        $lap->setMaxHr($valueLap->MaximumHeartRateBpm->Value);
                        $lap->setCalorie($valueLap->Calories);
                        $lap->setIntensity($valueLap->Intensity);
//                        echo "&nbsp; Lap start time=";echo $valueLap->attributes()['StartTime'];echo "<br/>";
//                        echo "&nbsp;&nbsp;Time=";echo $valueLap->TotalTimeSeconds;echo "<br/>";
//                        echo "&nbsp;&nbsp;Distance=";echo $valueLap->DistanceMeters;echo "<br/>";
//                        echo "&nbsp;&nbsp;Max speed=";echo $valueLap->MaximumSpeed;echo "<br/>";
//                        echo "&nbsp;&nbsp;Avg HR=";echo $valueLap->AverageHeartRateBpm->Value;echo "<br/>";
//                        echo "&nbsp;&nbsp;Max HR=";echo $valueLap->MaximumHeartRateBpm->Value;echo "<br/>";
//                        echo "&nbsp;&nbsp;Calories=";echo $valueLap->Calories;echo "<br/>";
//                        echo "&nbsp;&nbsp;Intensity=";echo $valueLap->Intensity;echo "<br/>";
                        if (null !== $valueLap->Extensions->LX) {
//                            echo "&nbsp;&nbsp; Avg Speed=";echo $valueLap->Extensions->LX->AvgSpeed;echo "<br/>";
                            $lap->setAvgSpeed($valueLap->Extensions->LX->AvgSpeed);
                        }
                        foreach ($valueLap->Track as $valueTrack) {
                            $track = new Track();
                            $track->setLap($lap);

                            foreach ($valueTrack->Trackpoint as $valueTrackPoint) {
                                $trackPoint = new TrackPoint();
                                $trackPoint->setTrack($track);
                                $trackPoint->setStartTime(new \DateTime($valueTrackPoint->Time));
                                $trackPoint->setLatitude($valueTrackPoint->Position->LatitudeDegrees);
                                $trackPoint->setLongitude($valueTrackPoint->Position->LongitudeDegrees);
                                $trackPoint->setAltitude($valueTrackPoint->AltitudeMeters);
                                $trackPoint->setDistance($valueTrackPoint->DistanceMeters);
                                $trackPoint->setHr($valueTrackPoint->HeartRateBpm->Value);
//                                echo "&nbsp;&nbsp;&nbsp; Trackpoint Start time=";echo $valueTrackPoint->Time;echo "<br/>";
//                                echo "&nbsp;&nbsp;&nbsp; Latitude=";echo $valueTrackPoint->Position->LatitudeDegrees;echo "<br/>";
//                                echo "&nbsp;&nbsp;&nbsp; Longitude=";echo $valueTrackPoint->Position->LongitudeDegrees;echo "<br/>";
//                                echo "&nbsp;&nbsp;&nbsp; Altitude=";echo $valueTrackPoint->AltitudeMeters;echo "<br/>";
//                                echo "&nbsp;&nbsp;&nbsp; Distance=";echo $valueTrackPoint->DistanceMeters;echo "<br/>";
//                                echo "&nbsp;&nbsp;&nbsp; HR=";echo $valueTrackPoint->HeartRateBpm->Value;echo "<br/>";
                                if (null !== $valueTrackPoint->Extensions->TPX) {
                                    $trackPoint->setSpeed($valueTrackPoint->Extensions->TPX->Speed);
//                                    echo "&nbsp;&nbsp;&nbsp; Speed=";echo $valueTrackPoint->Extensions->TPX->Speed;echo "<br/>";
                                }
                                $trackPoints[] = $trackPoint;
//                                echo "<br/>";
                            }
                            $tracks[] = $track;
//                            echo "<br/>";
                        }
                        $laps[] = $lap;
                    }
                    $activities[]=$activity;
                }
            }
        }
        return array($activities,$laps,$tracks,$trackPoints);
    }
}