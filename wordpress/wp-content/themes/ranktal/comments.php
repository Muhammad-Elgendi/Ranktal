<div class="comments-wrapper">
<div class="comments" id="comments">
    <div class="comments-header">
        <h2 class="comment-reply-title">
        <?php

            if(have_comments()){
                echo '<hr aria-hidden="true">';
                echo get_comments_number()." Comments";
            }
        ?>
        </h2><!-- .comments-title -->
    </div><!-- .comments-header -->

    <div class="comments-inner">
        <?php
            wp_list_comments(array(
                'avatar_size' => 48,
                'style' => 'div'
            ));
        ?>    
    </div><!-- .comments-inner -->

</div><!-- comments -->

<hr class="" aria-hidden="true">

<!-- replies section -->

<?php
    if(comments_open()){
        
        $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );

        $fields =  array( 
            'author' =>
            '<p class="comment-form-author"><div class="form-group"><label for="author">' . __( 'Name', 'domainreference' ) . '</label> ' .
            ( $req ? '<span class="required">*</span>' : '' ) .
            '<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
            '" ' . $aria_req . ' /></div></p>',        
            'email' =>
            '<p class="comment-form-email"><div class="form-group"><label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' .
            ( $req ? '<span class="required">*</span>' : '' ) .
            '<input id="email" name="email" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
            '" ' . $aria_req . ' /></div></p>',        
            'url' =>
            '<p class="comment-form-url"><div class="form-group"><label for="url">' . __( 'Website', 'domainreference' ) . '</label>' .
            '<input id="url" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
            '"   /></p>',
        );
        $comments_args = array(   
            // change "Leave a Reply" to "Discuss this post ?"
            'title_reply'=>'Discuss this post ?',
            'fields' => apply_filters( 'comment_form_default_fields', $fields ),
            'comment_field' =>  '<p class="comment-form-comment"><div class="form-group"><label for="comment">' . _x( 'Comment', 'noun' ) .
                '</label><textarea id="comment" name="comment" class="form-control"  rows="8" aria-required="true">' .
                '</textarea></div></p>',
                'comment_notes_after' => ' ',
                'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
                'title_reply_after' => '</h2>');

        comment_form($comments_args);
    }    
?>

</div>