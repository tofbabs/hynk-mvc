<?php

	/*
	** @Gearman Worker
	** Send Email via an API
	*/
	require '../vendor/autoload.php';

	require_once "SendMail.php";

	$worker = new GearmanWorker();
	$worker->addServer();

	$worker->addFunction("send_email", function(GearmanJob $job) {
	    $workload = json_decode($job->workload());
	    print_r($workload);
	    // You would then, of course, actually call this:

	    $sendgrid = new SendGrid('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');

	    $email = new SendGrid\Email();
	    $email->addTo($workload->email)
	    ->setFrom($workload->from))
	    ->setSubject($workload->subject)
	    ->setText($workload->body);

	    $sendgrid->send($email);
	});
	while ($worker->work());

?>
