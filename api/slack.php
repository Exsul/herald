<?php

class slack extends api
{
  protected function Reserve()
  {
  }

  private function InitClient()
  {
    $settings = [
        'username' => 'JIRA',
        'link_names' => true,
        'icon' => ':jira:',
    ];

    $client = new Maknz\Slack\Client('https://hooks.slack.com/services/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', $settings);

    return $client;
  }

  protected function Send($isget = false, $from = null, $to = null, $message = null)
  {
    if (!$isget)
    {
      $from = $_POST['from'];
      $to = $_POST['to'];
      $message = $_POST['message'];
    }

    $ch = curl_init();
    $to = curl_unescape($ch, $to);
    curl_close($ch);

    $client = $this->InitClient();
    $ch = $client->createMessage();
    $ch->from($from);
    $ch->to($to);

    if (isset($_POST['attach']))
      $ch->attach($_POST['attach']);

    if (isset($_POST['message']) && is_string($_POST['message']))
      $ch->send($_POST['message']);
    else
      $ch->send();
  }
}
