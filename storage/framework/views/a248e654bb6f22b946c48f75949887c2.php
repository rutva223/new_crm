<?php if($project_id == 0): ?>
    <?php echo e(Form::open(['route' => ['project.task.store', 0]])); ?>

<?php else: ?>
    <?php echo e(Form::open(['route' => ['project.task.store', $project_id]])); ?>

<?php endif; ?>
<?php
    $plansettings = App\Models\Utility::plansettings();
?>
<div class="row">
    <?php if(isset($plansettings['enable_chatgpt']) && $plansettings['enable_chatgpt'] == 'on'): ?>
        <div class="text-end">
            <a href="#" data-size="lg" data-ajax-popup-over="true"
                data-url="<?php echo e(route('generate', ['project task'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                title="<?php echo e(__('Generate')); ?>" data-title="<?php echo e(__('Generate')); ?>" float-end>
                <span class="btn btn-primary btn-sm"> <i class="fas fa-robot"> <?php echo e(__('Generate With AI')); ?></span></i>
            </a>
        </div>
    <?php endif; ?>

    <?php if($project_id == 0): ?>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('title', __('Title'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Task Title')])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('project', __('Project'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('project', $projects, '', ['class' => 'form-control multi-select', 'required' => 'required'])); ?>

        </div>
    <?php else: ?>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('title', __('Title'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Task Title')])); ?>

        </div>
    <?php endif; ?>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('priority', __('Priority'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::select('priority', $priority, '', ['class' => 'form-control multi-select', 'required' => 'required'])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::date('start_date', new \DateTime(), ['class' => 'form-control'])); ?>

    </div>
    <div class="form-group col-md-6">
        <?php echo e(Form::label('due_date', __('Due Date'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::date('due_date', new \DateTime(), ['class' => 'form-control'])); ?>

    </div>
    <?php if($project_id == 0): ?>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('assign_to', __('Assign To'), ['class' => 'col-form-label'])); ?>

            <select class="form-control" name="assign_to" id="assign_to" data-toggle="select" required>

            </select>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('milestone_id', __('Milestone'), ['class' => 'col-form-label'])); ?>

            <select class="form-control" name="milestone_id" id="milestone_id" data-toggle="select">

            </select>
        </div>
    <?php else: ?>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('assign_to', __('Assign To'), ['class' => 'col-form-label'])); ?>

            <?php echo Form::select('assign_to', $users, null, ['class' => 'form-control multi-select', 'required' => 'required']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('milestone_id', __('Milestone'), ['class' => 'col-form-label'])); ?>

            <?php echo Form::select('milestone_id', $milestones, null, ['class' => 'form-control multi-select']); ?>

        </div>
    <?php endif; ?>
    <div class="form-group  col-md-6">
        <?php echo e(Form::label('hours', __('Estimation Hours'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::number('hours', null, ['class' => 'form-control', 'required' => 'required'])); ?>

    </div>
    <div class="form-group col-md-12">
        <?php echo e(Form::label('description', __('Description'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::textarea('description', '', ['class' => 'form-control', 'rows' => '3'])); ?>

    </div>
    <?php if(
        !empty(App\Models\Utility::settings()['is_googleCal_enabled']) &&
            App\Models\Utility::settings()['is_googleCal_enabled'] == 'on'): ?>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('synchronize_type', __('Synchroniz in Google Calendar ?'), ['class' => 'form-label'])); ?>

            <div class=" form-switch">
                <input type="checkbox" class="form-check-input mt-2" name="synchronize_type" id="switch-shadow"
                    value="google_calender">
                <label class="form-check-label" for="switch-shadow"></label>
            </div>
        </div>
    <?php endif; ?>

</div>

<div class="modal-footer pr-0">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Create'), ['class' => 'btn  btn-primary'])); ?>

</div>
<?php echo e(Form::close()); ?>



<script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>

<script>
    if ($(".multi-select").length > 0) {
        $($(".multi-select")).each(function(index, element) {
            var id = $(element).attr('id');
            var multipleCancelButton = new Choices(
                '#' + id, {
                    removeItemButton: true,
                }
            );
        });
    }
</script>
<?php /**PATH /var/www/html/product/crmgo-saas/main_file/resources/views/project/taskCreate.blade.php ENDPATH**/ ?>