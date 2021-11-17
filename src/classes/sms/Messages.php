<?php

namespace Smsfire\Sms;

use Smsfire\Client;
use Smsfire\Traits\Sanitization;

class Messages extends Client {

  use Sanitization;

  private $client;
  protected $destinations;
  protected $to;
  protected $text;
  protected $campaignId;
  protected $customId;
  protected $flash;
  protected $allowReply;
  protected $scheduleTime;
  protected $fractionate;

  function __construct($token) {
    $this->client = parent::__construct($token);
  }

  public function sendIndividual($to, $text, $from = null, $customId = null, $campaignId = null, $flash = false, $allowReply = false, $scheduleTime = null) {
    $this->to = $this->smsToParameter($to);
    $this->text = $this->smsTextParameter($text);
    $this->from = $this->smsFromParameter($from);
    $this->customId = $this->smsCustomIdParameter($customId);
    $this->campaignId = $this->smsCampaignIdParameter($campaignId);
    $this->flash = $this->smsFlashParameter($flash);
    $this->allowReply = $this->smsAllowReplyParameter($allowReply);
    $this->scheduleTime = $this->dateTimeIso8601($scheduleTime);

    echo $this->scheduleTime;
  }

}
