<!DOCTYPE html>
<?php include "./view/header.php"; ?>
<body>
    <?php include "./view/navigationWithLogout.php"; ?>
    <h1>Hello <?php echo $_SESSION['user']['profileName'] ?></h1>
    <h2>Wag That Thumb!</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <div id="wag">

            <textarea name="wag"  maxlength="140"></textarea>
            <input type="hidden" name="action" value="submitWag" />
            <input type="file" id="myFile" name="image"/>
                
        </div>
        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" value="Send Wag"><br>
        </div>
    </form>
    </br>

    <form action ="likeController.php" method="post">
        <table id="wagDisplay">
            <?php $index=0;
            foreach ($wags as $wag) :  ?>
            
                <tr>
                    <td><input class ="wagUser" name="wagUser[]" value="<?php echo $wag['username']; ?>"  readonly="readonly"/></td>
                    <td ><input class ="likedWag" name="likedWag[]" value="<?php echo $wag['wag']; ?>"  readonly='readonly' ></td>
                    <?php if($wag['image'] != ""){
                         $image = "<td><img src='data:image/jpeg;base64,".base64_encode( $wag['image'])."'></td>";
                    }else {$image ="<td><div class='blank' ></div></td>";}
                    echo $image;
                    ?>
                    <td class="like"><?php echo $wag['likes']; ?></td>
                    <td class="likeButton">
                        
                        <input type="hidden" name="count" value ="<?php echo $index;?>"/>
                        <input type="submit" value="Like" name="likeButton[<?php echo $index?>]" />
                    </td>
                </tr>
            <?php $index++;
            endforeach; ?>
        </table>
    </form>

    <?php include './view/footer.php'; ?>


