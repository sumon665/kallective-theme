<?php
  $commenter    = wp_get_current_commenter();
  $comment_form = array(
    /* translators: %s is product title */
    'title_reply'         => '',
    /* translators: %s is product title */
    'title_reply_to'      => '',
    'title_reply_before'  => '',
    'title_reply_after'   => '',
    'comment_notes_after' => '',
    'label_submit'        => esc_html__( 'Submit', 'woocommerce' ),
    'logged_in_as'        => '',
    'comment_field'       => '',
    'class_container'     => '',
    'id_form'             => 'product-review',
    'class_form'          => 'product-review-form',
    'class_submit'        => 'btn-primary',
    'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s">%4$s</button>',
		'submit_field'         => '<div class="product-review-form__submit">%1$s %2$s</div>',
  );

  $name_email_required = (bool) get_option( 'require_name_email', 1 );
  $fields              = array(
    'author' => array(
      'label'    => __( 'Name', 'woocommerce' ),
      'type'     => 'text',
      'value'    => $commenter['comment_author'],
      'required' => $name_email_required,
    ),
    'email'  => array(
      'label'    => __( 'Email', 'woocommerce' ),
      'type'     => 'email',
      'value'    => $commenter['comment_author_email'],
      'required' => $name_email_required,
    ),
  );

  $comment_form['fields'] = array();

  foreach ( $fields as $key => $field ) {
    $field_html  = '<div class="product-review-form__row"><div class="control-input">';
    $field_html .= '<label for="' . esc_attr( $key ) . '" class="control-label">' . esc_html( $field['label'] );

    if ( $field['required'] ) {
      $field_html .= '&nbsp;<span class="required">*</span>';
    }

    $field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></div></div>';

    $comment_form['fields'][ $key ] = $field_html;
  }

  $account_page_url = wc_get_page_permalink( 'myaccount' );
  if ( $account_page_url ) {
    /* translators: %s opening and closing link tags respectively */
    $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
  }

  if ( wc_review_ratings_enabled() ) {
    $comment_form['comment_field'] = '<div class="product-review-form__row"><div class="control-rating"><div class="control-label">Choose rating' . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</div><div class="rating">' .
      '<input type="radio" id="rating-5" name="rating" value="5"><label for="rating-5" class="control-rating__icon"></label>' .
      '<input type="radio" id="rating-4" name="rating" value="4"><label for="rating-4" class="control-rating__icon"></label>' .
      '<input type="radio" id="rating-3" name="rating" value="3"><label for="rating-3" class="control-rating__icon"></label>' .
      '<input type="radio" id="rating-2" name="rating" value="2"><label for="rating-2" class="control-rating__icon"></label>' .
      '<input type="radio" id="rating-1" name="rating" value="1" required="required"><label for="rating-1" class="control-rating__icon"></label>' .
    '</div></div></div>';
  }

  $comment_form['comment_field'] .= '<div class="product-review-form__row"><div class="control-input"><label for="comment" class="control-label">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" required="required"></textarea></div></div>';

?>
<div class="modal" id="review-modal">
  <div id="review_form_wrapper" class="modal-dialog">
    <div id="review_form" class="modal-content">
      <div class="modal-header">
       <?php echo __(' Add new review', 'kallective');?>
        <span class="modal-header__close close-modal"></span>
      </div>
      <div class="modal-body">
        <?php
        comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
        ?>
      </div>
    </div>
	</div>
</div>