<div class="modal-body">
    <p><?= __('please_select') . ' ' . __('pin_' . $this->data_type) . ' ' . __('use_checkbox') ?></p>

    <div class='list-group gallery'>
        <input type="hidden" name="data-type" value="<?= $this->data_type ?>"/>
    </div>
    <script>
        $(document).ready(function () {
            <?php foreach ($viewmodel as $image) : ?>
            var indDb = '<?=((isset($image[$this->data_type]) && ($image[$this->data_type] > 0))) ? 'checked' : '' ; ?>';
            var dataId = $('input[name="dataId"]').val();
            var checked = (dataId == '<?=$image[$this->data_type]?>' && indDb != '') ? 'checked' : '';
            $('.gallery').append('<div class="images-admin img-relative <?=($image['type'] == 1) ? 'images-box-'.$image['id'] : 'video-box-'.$image['id']?>" style="display: none"></div>');
                App.thumbVideo(<?=$image['id']?>,'<?=$image['image']?>','<?= $image['image_thumb'] ?>',<?=$image['type']?>);
                $('.<?=($image['type'] == 1) ? 'images-box-'.$image['id'] : 'video-box-'.$image['id']?>').append('' +
                    '<div style="padding-top:0" class="checkbox checkbox-success checkbox-img" name="<?= $image['id'] ?>" data-value="' + dataId + '"><input id="checkbox<?= $image['id'] ?>" type="checkbox" ' + checked + ' ><label for="checkbox<?= $image['id'] ?>"></label></div>'
                );
            <?php endforeach; ?>
            $('.gallery').find('div.images-admin').each(function (i, el) {
                $(el).fadeIn('slow');
            });

            $('button.pin-btn').removeClass('btn-info');
            $('button.pin-btn[data-type="' + $('input[name="data-type"]').val() + '"]').addClass('btn-info');

            $('.checkbox-img').on('click', function () {
                var action = 'delete';
                if ($(this).find('input[type="checkbox"]').is(':checked')) {
                    action = 'assign';
                }
                App.ajaxSend('<?=createUrl('admin','assign')?>', {
                    'dataType': $('input[name="data-type"]').val(),
                    'imgId': $(this).attr('name'),
                    'prodId': $(this).attr('data-value'),
                    'action': action
                });
            })
        })
    </script>
</div>