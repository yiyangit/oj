<?php
$title = 'Status';
$stylesheets = array('verdicts');
include(__DIR__ . '/../layout/header.php');
?>
<form method="GET" action="<?php echo SITE_BASE; ?>/status" class="pull-right form-search">
  <input type="text" class="input-small search-query" placeholder="Who" name="owner" maxlength="100" value="<?php echo $this->owner; ?>">
  <input type="number" class="input-small search-query" placeholder="What" name="problem" maxlength="10" value="<?php echo $this->problem_id; ?>">
  <select name="language" class="input-small search-query">
  <?php
    $languages = array('How', 'C++', 'C', 'Java');
    foreach ($languages as $value => $text) {
      fHTML::printOption($text, $value, $this->language);
    }
  ?>
  </select>
  <select name="verdict" class="input-small search-query">
  <?php
    $verdicts = array('Verdict', 'AC', 'PE', 'TLE', 'MLE', 'WA', 'RE', 'OLE', 'CE', 'SE', 'VE');
    foreach ($verdicts as $value => $text) {
      fHTML::printOption($text, $value, $this->verdict);
    }
  ?>
  </select>
  <button type="submit" class="btn btn-primary">Filter</button>
  <?php if (strlen($this->owner) or strlen($this->problem_id) or !empty($this->language) or !empty($this->verdict)): ?>
    <a class="btn" href="<?php echo SITE_BASE; ?>/status">Cancel</a>
  <?php endif; ?>
</form>
<h1>Problem Status List</h1>
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Run ID</th>
      <th>Who</th>
      <th>What</th>
      <th>Result</th>
      <th>Time</th>
      <th>Memory</th>
      <th>How</th>
      <th>When</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->records as $r): ?>
      <tr>
        <td><a href="<?php echo $this->top_url; ?><?php echo $r->getId(); ?>"><?php echo $r->getId(); ?></a></td>
        <td><?php echo fHTML::encode($r->getOwner()); ?> <?php echo Profile::fetchRealName($r->getOwner())?></td>
        <td><a href="<?php echo SITE_BASE; ?>/problem/<?php echo $r->getProblemId(); ?>"><?php echo $r->getProblemId(); ?></a></td>
        <td>
          <?php if ($r->isReadable()): ?>
            <a class="record<?php echo str_replace(' ', '', $r->getResult()); ?>" 
               href="<?php echo SITE_BASE; ?>/record/<?php echo $r->getId(); ?>"><?php echo $r->getResult(); ?></a>
          <?php else: ?>
            <span class="record<?php echo str_replace(' ', '', $r->getResult()); ?>"><?php echo $r->getResult(); ?></span>
          <?php endif; ?>
        </td>
        <td><?php echo $r->getTimeCost(); ?></td>
        <td><?php echo $r->getMemoryCost(); ?></td>
        <td><?php echo fHTML::encode($r->getLanguageName()); ?></td>
        <td><?php echo $r->getSubmitDatetime(); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php
include(__DIR__ . '/../layout/footer.php');
