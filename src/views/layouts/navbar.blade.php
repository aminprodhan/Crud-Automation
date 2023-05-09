<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <?php
        use Aminpciu\CrudAutomation\app\Helper\CommonTrait;
        $config=CommonTrait::getConfig();
    ?>
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">{{$config->navbar_title ?? 'Laravel'}}</span>
    </div>
  </nav>
