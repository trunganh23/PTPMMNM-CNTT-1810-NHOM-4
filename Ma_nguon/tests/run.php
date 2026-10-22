<style>body{background-color:#1e293b!important;color:#ffffff!important;} *{color:#ffffff!important;} .card,form{background-color:#334155!important;border:1px solid #475569!important;} input,select{background-color:#0f172a!important;color:#ffffff!important;} button,input[type="submit"]{background:#2563eb!important;color:#ffffff!important;}</style>
<?php
require __DIR__.'/helper.php';
require __DIR__.'/../src/Draft.php';
$s = ['csrf'=>'keep'];
saveDraft($s,['event_id'=>1,'name'=>'Demo'],1000);
same($s['draft']['data']['event_id'],1,'saved');
same(draftExpired($s,1299,300),false,'before-expiry');
same(draftExpired($s,1300,300),true,'at-expiry');
cancelDraft($s);
same(isset($s['draft']),false,'cancelled');
same($s['csrf'],'keep','unrelated-state-kept');
same(draftExpired($s,1000,300),true,'no-draft');
finish();
