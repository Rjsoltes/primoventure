<!-- edit_post.php displays a form that
     allows a post's information to be changed. -->
<?php
    // Gets the post id from the post where the edit button was clicked
    if(isset($_GET['p_id'])){
        $the_post_id = $_GET['p_id'];
    }
    
    // Creates query to retrtieve information about post to display in the edit post
    // fields of the form, so users can see what information they're editing.
    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
    $select_posts_by_id = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_posts_by_id)){

        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_content = $row['post_content'];

    }
    
    // Checks all information put into the fields of the form
    // Creates query with all the new information and sends it to the database.
    if(isset($_POST['update_post'])){
        $post_title = $_POST['post_title'];
        $post_author = $_POST['post_author'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
        
        move_uploaded_file($post_image_temp, "../img/$post_image");
        
        $query = "UPDATE posts SET ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_category_id = '{$post_category_id}', ";
        $query .= "post_date = now(), ";
        $query .= "post_author = '{$post_author}', ";
        $query .= "post_status = '{$post_status}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_content = '{$post_content}', ";
        $query .= "post_image = '{$post_image}' ";
        $query .= "WHERE post_id = {$the_post_id} ";
    
        $update_post = mysqli_query($connection, $query);
        confirm($update_post);
        echo "<p class='bg-success'>Post Updated!</p>";
    }
?>

<!-- Creates table to edit a post
        Fields have information that are already connected to 
        the post being edited, so user can say what is being edited.     
-->
   <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <label for="post_category_id">Post Category</label><br>
        <select name="post_category" id="">
            <?php
                // Creates query to retrieve catagroy options for select element in form.
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);
                confirm($select_categories);
                while($row = mysqli_fetch_assoc($select_categories)){
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            
            ?>
            
        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="post_author">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input value="<?php echo $post_status; ?>" type="text" class="form-control" name="post_status">
    </div>
    <div class="form-group">
        <img src="../img/<?php echo $post_image; ?>" width="75" alt="">
        <label for="post_image">Post Image</label>
        <input type="file" name="image" value="<?php echo $post_image; ?>">
    </div>
     <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10" ><?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update">
    </div>
</form>