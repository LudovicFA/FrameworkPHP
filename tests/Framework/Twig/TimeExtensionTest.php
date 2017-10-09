<?php

namespace  Tests\Framework\Twig;

use Framework\Twig\TimeExtension;
use PHPUnit\Framework\TestCase;

class TimeExtensionTest extends TestCase
{

  private $timeExtension;

  public function setUp()
  {
      $this->timeExtension = new TimeExtension();
  }

  public function testDateFormat()
  {
    $date = new \Datetime();
    $format = 'd/m/Y H:i';
    $result = '<span class="timeago" datetime="'. $date->format(\Datetime::ISO8601) .'">'.$date->format($format).'</span>';
    $this->assertEquals($result, $this->timeExtension->ago($date));
  }



}
