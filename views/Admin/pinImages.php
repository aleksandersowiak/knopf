<?= __('please_select') . ' ' . __('pin_' . $this->data_type) . ' ' . __('use_checkbox') ?>
<div class="modal-body">
    <div class='list-group gallery'>
        <input type="hidden" name="data-type" value="<?= $this->data_type ?>"/>
    </div>
    <script>
        $(document).ready(function () {
            <?php foreach ($viewmodel as $image) : ?>
            var checked = '<?=($image[$this->data_type] > 0) ? 'checked' : '' ; ?>';
            $('.gallery').append('<div class="images img-relative" style="display: none">' +

                '<img style="max-height:150px; min-height:150px;  min-width:150px;  max-width:150px;  overflow: hidden; background: url(<?= $image['image'] ?>) no-repeat 50% 50%; background-size:cover;"/>' +
                '<input type="checkbox" '+checked+' class="checkbox-img" name="<?= $image['id'] ?>" value="' + $('input[name="dataId"]').val() + '" />' +

                '</div>');
            <?php endforeach; ?>
            $('.gallery').find('div').each(function (i, el) {
                $(el).fadeIn('slow');
            })

            $('.checkbox-img').on('click', function () {
                var action = 'delete';
                if ($(this).is(':checked')) {
                    action = 'assign';
                }
                App.ajaxSend('<?=createUrl('admin','assign')?>', {
                    'dataType': $('input[name="data-type"]').val(),
                    'imgId': $(this).attr('name'),
                    'prodId': $(this).val(),
                    'action': action
                });
            })
        })
    </script>
</div>