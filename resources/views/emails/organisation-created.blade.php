<?php
/** @var App\Models\Organisation $organisation */
?>
<h2>Hello {{ $organisation->owner->name }}</h2>

<p>Your organisation {{ $organisation->name }} has successfully been created.</p>
