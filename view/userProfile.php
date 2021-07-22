<!DOCTYPE html>
<?php include "./view/header.php"; ?>
<body>
    <?php
    if (isset($_SESSION['isLoggedIn'])) {//if user is logged in show logout nav
        include "./view/navigationWithLogout.php";
    } else {
        include "./view/navigation.php";
    }//if user is not logged in, show login nav
    ?>


    <h1><?php echo $user ?></h1>

<?php

echo $followButton;
echo $editProfileButton
?>

    <form action ="likeController.php" method="post">
        <table id="wagDisplay">
<?php $likeIndex = 0;

foreach ($wags as $wag) :
    ?>

                <tr>
                    <td><input class ="wagUser" name="wagUser[]" value="<?php echo $wag['username']; ?>"  readonly="readonly"/></td>
                    <td><input class ="likedWag" name="likedWag[]" value="<?php echo $wag['wag']; ?>"  readonly='readonly' ></td>
                    <?php if($wag['image'] != ""){
                         $image = "<td><img class = 'image' src='data:image/jpeg;base64,".base64_encode( $wag['image'])."'></td>";
                    }else {$image ="<td id='blank'></td>";}
                    echo $image;
                    ?>
                    <td class="like"><?php echo $wag['likes']; ?></td>
                    <?php
                    if (isset($_SESSION['isLoggedIn'])) {// if user is logged in then show like button
                        $likeButton = "<td class='likeButton'>
                        <input type='hidden' name='action' value='userProfile'/>
                        <input type='hidden' name='count' value ='$likeIndex'/>
                        <input type='submit' value='Like' name='likeButton[$likeIndex]' />
                    </td>";
                    }
                    
                   
                    echo $likeButton;
                    ?>
                    
                    
                </tr>
    <?php $likeIndex++;
endforeach;
?>
        </table>
    </form>
<?php include './view/footer.php'; ?>


