<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<!-- <div class="message success" onclick="this.classList.add('hidden')"><?= $message ?></div> -->
<div class="alert alert-success d-flex align-items-center" role="alert" onclick="this.classList.add('d-none');">
  <div>
    <?= $message ?>
  </div>
</div>
