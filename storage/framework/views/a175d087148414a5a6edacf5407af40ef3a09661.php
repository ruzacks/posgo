<?php echo e(Form::open(['url' => 'todos'])); ?>


<div class="modal-body">
    <div class="form-group">
        <?php echo e(Form::label('title', __('Title'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::text('title', null, ['class' => 'form-control','placeholder' => __('Enter task title'),'id' => 'title'])); ?>

        <span class="invalid-title d-none" role="alert">
            <small class="text-danger"><?php echo e(__('This field is required.')); ?></small>
        </span>
    </div>

    <div class="form-group">
        <?php echo e(Form::label('color', __('Priority Color'), ['class' => 'd-block col-form-label'])); ?>

        <div class=" btn-group-toggle btn-group-colors event-tag mb-0" data-toggle="buttons">
            <label class="btn bg-info active p-3"><input type="radio" name="color" value="info" autocomplete="off"
                    checked="" class="d-none"></label>
            <label class="btn bg-warning  p-3"><input type="radio" name="color" value="warning" autocomplete="off"
                    class="d-none"></label>
            <label class="btn bg-danger  p-3"><input type="radio" name="color" value="danger" autocomplete="off"
                    class="d-none"></label>
            <label class="btn bg-success  p-3"><input type="radio" name="color" value="success" autocomplete="off"
                    class="d-none"></label>
            
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Create')); ?>">
</div>

<script>
    $(document).ready(function() {
        $('form').submit(function() {
            if ($.trim($("#title").val()) === "") {
                $("#title").focus();
                $('.invalid-title').removeClass('d-none');
                return false;
            }
        });
    });
</script>
<?php echo e(Form::close()); ?>

<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/todos/create.blade.php ENDPATH**/ ?>