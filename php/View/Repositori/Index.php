<?php
if (isset($Args['Repositori'])) {

    $F = new F_Help();
    $PagesA = $F->NewPager($Args['Page'], $Args['Pages'], $Args['url']);
    ?>

    <center>
        Repositori Count: <?php echo $Args['Count']; ?><br/>
        Page: <?php echo $Args['Page']; ?> Pages: <?php echo $Args['Pages']; ?><br/>
        <?php echo $PagesA; ?>

        <br/><a href="/Repositori/NewOrEdit/">New Repositori</a><br/>
    </center>

    <?php
    foreach ($Args['Repositori'] as $val) {
        ?>

        <a href="/Repositori/NewOrEdit/<?php echo $val->Id; ?>">Repositori Edit</a><br/>
        <a href="/Repositori/ReposiFiles/<?php echo $val->Id; ?>">Repositori Files</a><br/>
        <b class="green">Repositori Name:</b> <?php echo $val->Name; ?><br/>
        <b class="green">Repositori Description:</b> <?php echo $val->Description; ?><br/>
        <hr/><br/>

        <?php
    }

    echo '<br/><center>' . $PagesA . '</center>';
} else if (isset($_SESSION['Id'])) {
    ?>    


    <center>
        Repositories

        <br/><a href="/Repositori/NewOrEdit/">New Repositori</a><br/>
        <br/>No Repositori
    </center>    


    <?php
} else {
    ?>   
    <center><h1>
            Please login in scm
        </h1>
    </center> 

    <?php
}
?>

