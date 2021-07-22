<!DOCTYPE html>
<?php include "./view/header.php"; ?>
<body>
    <?php include "./view/navigation.php"; ?>
    <h1>Welcome to Thumb Wag!</h1>
    <h3>Wags from members of the community</h3>
    <table>
        <?php foreach ($wags as $wag) : ?>
            <tr>
                <td class ="wagUser"><?php echo $wag['username']; ?></td>
                <td class ="likedWag"><?php echo $wag['wag']; ?></td>
                 <?php if($wag['image'] != ""){//Shows image 
                         $image = "<td><img src='data:image/jpeg;base64,".base64_encode( $wag['image'])."'></td>";
                    }else {$image ="<td><div class='blank' ></div></td>";}
                    echo $image;
                    ?>
                <td class ="like"><?php echo $wag['likes'] . " Likes"; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php include './view/footer.php'; ?>


