<!-- slanje maila-->
<div class="st-content-inner">
    <div class="container">
        <div class="timeline-block">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="media">
                        <div class="media-body">
                            <h5>Pretraga predavaca</h5>
                        </div>
                    </div>
                </div>
                <div class="view-all-comments">
                            <span>
                                <?php if(count ($predavac)==1)
                                    echo '1 predavac';
                                else
                                    echo count($predavac).' predavaca';?>
                            </span>
                </div>
                <ul class="comments"  >
                    <?php foreach ($predavac as $pr):?>
                        <li class="media" >
                            <div class="media-left">
                                <a onclick="getSummary('<?php echo site_url('user/get_predavac_profil')?>/<?php echo $pr['idPred']?>', '<?php echo $pr['ime']?> <?php echo $pr['prezime']?>')">
                                    <?php
                                    $img =base_url().'img/predavac_default.jpg';
                                    if ($pr['slika']=='d') {
                                        $img =base_url().'/img/predavac/predavac'.$pr['idPred'].'.jpg?'."<?php echo random_int(0,10000)?>";
                                    }?>
                                    <img src="<?php echo $img?>" class="media-object" width="60" height="60"/>
                                </a>
                            </div>

                            <div class="media-body">
                                <a class="comment-author pull-left" 
                                   onclick="getSummary('<?php echo site_url('user/get_predavac_profil')?>/<?php echo $pr['idPred']?>', '<?php echo $pr['ime']?> <?php echo $pr['prezime']?>')">
                                    <?php echo $pr['ime']?> <?php echo $pr['prezime']?>
                                </a>
                                <div class="pull-right dropdown" >
                                    <a onclick="slanje_maila('<?php echo $pr['idPred']?>')"
                                       data-toggle="modal" data-target="#myModal4" class="toggle-button" data-tooltip="tooltip" title="Kontaktiraj">
                                        <i class="fa fa-comment fa-lg" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</div>