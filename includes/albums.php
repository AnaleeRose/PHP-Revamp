<?php require_once 'connection.php';

$conn = dbConnect('view');
define('SHOWMAX', 6);
$sql = "SELECT AlbumID, AlbumName, ImageName, dateCreated, dateUpdated FROM Albums LIMIT " . SHOWMAX;

?>

<section id="albums">
<div class="card card-body bg-dark">
    <h2  class="text-light text-center">Albums</h2>
        <div class="container font">
            <div class="row">

                <div class="col col-lg-6 test">
                    <h3 class="text-light card-title"></h3>
                    <img src="images/.jpg" class="card-img-fluid-sm rounded" alt="">
                        <ol class="text-light">
                        </ol>
                </div> <!-- col -->

                <div class="col col-lg-6 origins">
                    <h3 class="text-light card-title">Origins (Deluxe)</h3>
                    <a href="https://itunes.apple.com/us/album/origins-deluxe/1437948883"><img src="images/origins_.jpg" class="card-img-fluid-sm rounded" alt="origins"></a>
                        <ol class="text-light">
                            <li>Natural</li>
                            <li>Boomerang</li>
                            <li>Machine</li>
                            <li>Cool Out</li>
                            <li>Bad Liar</li>
                            <li>West Coast</li>
                            <li>Zero</li>
                            <li>Bullet In A Gun</li>
                            <li>Digital</li>
                            <li>Only</li>
                            <li>Stuck</li>
                            <li>Love</li>
                            <li>Birds</li>
                            <li>Burn Out</li>
                            <li>Real Life</li>
                        </ol>
                </div> <!-- col -->

                <div class="col col-lg-6 evolve">
                    <h3 class="text-light card-title">Evolve</h3>
                    <a href="https://itunes.apple.com/us/album/evolve/1411625594"><img src="images/evolve_.jpg" class="card-img-fluid-sm rounded" alt="Evolve"></a>
                        <ol class="text-light">
                            <li>Next to Me</li>
                            <li>I Don&apos;t Know Why</li>
                            <li>Whatever It Takes</li>
                            <li>Believer</li>
                            <li>Walking the Wire</li>
                            <li>Rise Up</li>
                            <li>I&apos;ll Make It Up to You</li>
                            <li>Yesterday</li>
                            <li>Mouth of the River</li>
                            <li>Thunder</li>
                            <li>Start Over</li>
                            <li>Dancing in the Dark</li>
                        </ol>
                </div> <!-- col -->

                <div class="col col-lg-6 smoke_mirrors">
                    <h3 class="text-light card-title">Smoke + Mirrors (Deluxe)</h3>
                    <a href="https://itunes.apple.com/us/album/smoke-mirrors-deluxe/1043732083"><img src="images/smoke_mirrors_.jpg" class="card-img-fluid-sm rounded" alt="Smoke + Mirrors"></a>
                        <ol class="text-light">
                            <li>Shots</li>
                            <li>Gold</li>
                            <li>Smoke and Mirrors</li>
                            <li>I&apos;m So Sorry</li>
                            <li>I Bet My Life</li>
                            <li>Polaroid</li>
                            <li>Friction</li>
                            <li>It Comes Back To You</li>
                            <li>Dream</li>
                            <li>Trouble</li>
                            <li>Summer</li>
                            <li>Hopeless Opus</li>
                            <li>The Fall</li>
                            <li>Thief</li>
                            <li>The Unknown</li>
                            <li>Second Chances</li>
                            <li>Release</li>
                            <li>Warriors</li>
                            <li>Battle Cry</li>
                            <li>Monster</li>
                            <li>Who We Are</li>
                        </ol>
                </div> <!-- col -->

                <div class="col col-lg-6 night_visions">
                    <h3 class="text-light card-title">Night Visions (Deluxe)</h3>
                    <a href="https://itunes.apple.com/us/album/night-visions-deluxe-version/598674954"><img src="images/night_visions_.jpg" class="card-img-fluid-sm rounded" alt="Night Visions"></a>
                        <ol class="text-light">
                            <li>Radioactive</li>
                            <li>Tiptoe</li>
                            <li>It&apos;s Time</li>
                            <li>Demons</li>
                            <li>On Top of the World</li>
                            <li>Amsterdam</li>
                            <li>Hear Me</li>
                            <li>Every Night</li>
                            <li>Bleeding Out</li>
                            <li>Underdog</li>
                            <li>Nothing Left to Say/Rocks</li>
                            <li>Working Man</li>
                            <li>Fallen</li>
                            <li>My Fault</li>
                            <li>Round and Round</li>
                            <li>The River</li>
                            <li>America</li>
                            <li>Selene</li>
                        </ol>
                </div> <!-- col -->
            </div> <!-- row -->
        </div> <!-- container -->
</div> <!-- card -->
</section> <!-- albums -->
