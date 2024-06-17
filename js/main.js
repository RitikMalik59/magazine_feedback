$( document ).ready(function() {
    // console.log( "ready!" );
      $('input[type=radio][name=answer_3]').change(function() {
        // console.log(this.value);
        if (this.value == 'yes') {
            $('#share_details').html('<textarea class="form-control" name="answer_3" id="question_3" placeholder="Kindly share the details ." rows="2"></textarea>');
        }
        else if (this.value == 'no') {
            $('#share_details').html('');
        }
    });

    
});