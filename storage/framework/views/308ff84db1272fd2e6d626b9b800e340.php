
<?php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
?>
<?php if(!empty(\Auth::user()->avatar)): ?>
    <div class="avatar av-l" style="background-image: url('<?php echo e(Auth::user()->avatar); ?>');">
    </div>
<?php else: ?>
    <div class="avatar av-l"
         style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').'/avatar.png')); ?>');">
    </div>
<?php endif; ?>
<p class="info-name"><?php echo e(config('chatify.name')); ?></p>
<div class="messenger-infoView-btns">
    
    <a href="#" class="danger delete-conversation"><i class="fas fa-trash-alt"></i> Delete Conversation</a>
</div>

<div class="messenger-infoView-shared">
    <p class="messenger-title">shared photos</p>
    <div class="shared-photos-list"></div>
</div><?php /**PATH C:\xampp\htdocs\new_crm\resources\views/vendor/Chatify/layouts/info.blade.php ENDPATH**/ ?>