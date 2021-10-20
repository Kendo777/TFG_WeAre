<?php 
if(!isset($_SESSION['user']))
{
  header('location:index.php?page=login');
}
if(isset($_GET["game"]))
{
    header('location:juegos/'.$_GET["game"].'/index.php');
}

 ?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
<script>
    $(document).ready(function() {
        var ctx = $("#chart-line");
        var myLineChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [<?php
                            $info = json_decode(file_get_contents("juegos".DIRECTORY_SEPARATOR."Elisa invaders".DIRECTORY_SEPARATOR."score.txt"),true);
                            for($i=0; $i<count($info); $i++)
                            {
                                if(!empty($info[$i]['name']))
                                {
                                    echo'"'.$info[$i]['name'].'"';
                                    if($i<count($info)-1)
                                    {
                                        echo ",";
                                    }
                                }
                            }
                        ?>],
                datasets: [{
                    data: [<?php
                            
                            for($i=0; $i<count($info); $i++)
                            {
                                if(!empty($info[$i]['name']))
                                {
                                    echo $info[$i]['score'];
                                    if($i<count($info)-1)
                                    {
                                        echo ",";
                                    }
                                }
                            }
                        ?>,0],
                    label: "Score",
                    borderColor: "#61A543",
                    backgroundColor: '#9AE85E',
                    fill: false
                }]
            },
            options: {
                title: {
                    display: false,
                    text: 'TOP 10 ELISA INVADERS'
                },
                //legend: { display: false }
            }
        });
    });
</script>
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row">
            <div class="container-fluid d-flex">
                <div class="col-sm-8 col-md-6">
                    <a href="index.php?page=games&game=Elisa Invaders"><h2>Elisa Invaders</h2></a>
                    <a href="index.php?page=games&game=Elisa Invaders"><img src="juegos/Elisa Invaders/style/sprites/portada.png" style="max-width: 100% !important"></a>
                    <a data-toggle="collapse" href="#collapseExample"><br><br>
                    <h5 style="display: inline;">Puntuacion</h5>  (Click aqui para ver)</a>
                    <div class="card" >
                        <div class="collapse" id="collapseExample">
                        <div class="card-header">
                            TOP 10 ELISA INVADERS
                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1">Graphic</button>
                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Arcade</button>

                        </div>
                        <div class="card-body collapse" style="height: 400px" id="multiCollapseExample1" data-parent="#collapseExample">
                            <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div> <canvas id="chart-line" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                        </div>

                        <div class="card-body collapse" style="height: 400px" id="multiCollapseExample2" data-parent="#collapseExample">
                            <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>Ranking</th>
                                <th>Jugador</th>
                                  <th>Puntuacion</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php 
                                for($i=0; $i<count($info); $i++)
                                {
                                    echo'<tr><td>'.($i+1).'</td><td>'.$info[$i]['name'].'</td><td>'.$info[$i]['score'].'</td></tr>';
                                }
                             ?>
                         </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>