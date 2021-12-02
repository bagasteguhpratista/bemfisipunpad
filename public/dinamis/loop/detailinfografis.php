<?php
  include '../../../global.php';
  global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
  $id = $_GET['id'];
  $sql  = "SELECT * FROM ". $var['table']['infografis'] . " WHERE status ='active' AND id = '".$id."' ORDER BY reorder ASC";
                db::query($sql, $rs['data'], $nr['data']);
                while($row  = db::fetch($rs['data']))
                {
                    $infografisdetail =  "SELECT * FROM ". $var['table']['infografis_image'] . " WHERE id_infografis_image='".$row['id']."' ORDER BY reorder ASC";
                    db::query($infografisdetail, $rs['infografisdet'], $nr['infografisdet']);
                    while($rowss  = db::fetch($rs['infografisdet']))
                    {
                        $row['images'][] = $var['v_images_url']."/infografis/". $rowss['image'];
                    }// all images
                    // $row['publish_date'] = admin::format_date($item['publish_date'],'id','A');
                    $data[] = $row;
                }
?>

<div id="carouselExample" class="bootstrap-css carousel slide" data-ride="carousel">
          <div class="bootstrap-css  carousel-inner">
        <?php 
          if(count($data) > 0){
            $x = 0;
            foreach($data as $item){ 
              $x++;
        ?>
        <?php 
              if(count($item['images']) > 0){
                for($i=0;$i < count($item['images']);$i++){ 
            ?>
            <div class="bootstrap-css  carousel-item">
              <img class="d-block w-100" src="<?= $item['images'][$i]?>">
            </div>
<?php
              }
            } 
          ?>
          </div>
          <?php 
          }
        }
      ?>
          <a class="bootstrap-css carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
            <span class="bootstrap-css carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class=" bootstrap-css carousel-control-next" href="#carouselExample" role="button" data-slide="next">
            <span class="bootstrap-css carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>