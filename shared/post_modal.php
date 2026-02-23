<!-------CREATE POST POPUP----->
<div class="post_box" id="post_box">
    <div class="post_box_header">
        <h3>Create New Post</h3>
        <div class="header_icon cursor-pointer" id="close_post">
            <svg aria-label="Close" class="fg7vo5n6 lrzqjn8y" color="#444" fill="#444" height="18" role="img" viewBox="0 0 48 48" width="18">
                <title>Close</title>
                <path clip-rule="evenodd" d="M41.8 9.8L27.5 24l14.2 14.2c.6.6.6 1.5 0 2.1l-1.4 1.4c-.6.6-1.5.6-2.1 0L24 27.5 9.8 41.8c-.6.6-1.5.6-2.1 0l-1.4-1.4c-.6-.6-.6-1.5 0-2.1L20.5 24 6.2 9.8c-.6-.6-.6-1.5 0-2.1l1.4-1.4c.6-.6 1.5-.6 2.1 0L24 20.5 38.3 6.2c.6-.6 1.5-.6 2.1 0l1.4 1.4c.6.6.6 1.6 0 2.2z" fill-rule="evenodd"></path>
            </svg>
        </div>
    </div>
    <div class="post-modal">
       <div class="post-content-left">
            <div class="preview_container">
                    <div class="p-container-add">
                        <div class="p-containter-add-icon">
                            <svg aria-label="Icon to represent media such as images or videos" class="_ab6-" color="#262626" fill="#262626" height="77" role="img" viewBox="0 0 97.6 77.3" width="96">
                                <path d="M16.3 24h.3c2.8-.2 4.9-2.6 4.8-5.4-.2-2.8-2.6-4.9-5.4-4.8s-4.9 2.6-4.8 5.4c.1 2.7 2.4 4.8 5.1 4.8zm-2.4-7.2c.5-.6 1.3-1 2.1-1h.2c1.7 0 3.1 1.4 3.1 3.1 0 1.7-1.4 3.1-3.1 3.1-1.7 0-3.1-1.4-3.1-3.1 0-.8.3-1.5.8-2.1z" fill="currentColor"></path>
                                <path d="M84.7 18.4L58 16.9l-.2-3c-.3-5.7-5.2-10.1-11-9.8L12.9 6c-5.7.3-10.1 5.3-9.8 11L5 51v.8c.7 5.2 5.1 9.1 10.3 9.1h.6l21.7-1.2v.6c-.3 5.7 4 10.7 9.8 11l34 2h.6c5.5 0 10.1-4.3 10.4-9.8l2-34c.4-5.8-4-10.7-9.7-11.1zM7.2 10.8C8.7 9.1 10.8 8.1 13 8l34-1.9c4.6-.3 8.6 3.3 8.9 7.9l.2 2.8-5.3-.3c-5.7-.3-10.7 4-11 9.8l-.6 9.5-9.5 10.7c-.2.3-.6.4-1 .5-.4 0-.7-.1-1-.4l-7.8-7c-1.4-1.3-3.5-1.1-4.8.3L7 49 5.2 17c-.2-2.3.6-4.5 2-6.2zm8.7 48c-4.3.2-8.1-2.8-8.8-7.1l9.4-10.5c.2-.3.6-.4 1-.5.4 0 .7.1 1 .4l7.8 7c.7.6 1.6.9 2.5.9.9 0 1.7-.5 2.3-1.1l7.8-8.8-1.1 18.6-21.9 1.1zm76.5-29.5l-2 34c-.3 4.6-4.3 8.2-8.9 7.9l-34-2c-4.6-.3-8.2-4.3-7.9-8.9l2-34c.3-4.4 3.9-7.9 8.4-7.9h.5l34 2c4.7.3 8.2 4.3 7.9 8.9z" fill="currentColor"></path>
                                <path d="M78.2 41.6L61.3 30.5c-2.1-1.4-4.9-.8-6.2 1.3-.4.7-.7 1.4-.7 2.2l-1.2 20.1c-.1 2.5 1.7 4.6 4.2 4.8h.3c.7 0 1.4-.2 2-.5l18-9c2.2-1.1 3.1-3.8 2-6-.4-.7-.9-1.3-1.5-1.8zm-1.4 6l-18 9c-.4.2-.8.3-1.3.3-.4 0-.9-.2-1.2-.4-.7-.5-1.2-1.3-1.1-2.2l1.2-20.1c.1-.9.6-1.7 1.4-2.1.8-.4 1.7-.3 2.5.1L77 43.3c1.2.8 1.5 2.3.7 3.4-.2.4-.5.7-.9.9z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <div class="p-container-add-subtitle">
                            Drag photos and videos here
                        </div>
                        <div class="file-upload-contaier">
                            <label for="post_photo" class="post_photo_text">
                                Select from Computer
                            </label>
                            <input type="file" class="input_file_upload" id="post_photo" name="post_photo" data-multiple-caption="{count} files selected" multiple="">
                        </div>

                    </div>
                    <img  id="imgPreview" class="post__media preview__image display_none"/>
            </div>
       </div>
       <div class="post-content-right">
               <div class="post__profile">
                    <a href="<?php echo url_for('profile/'.$user->username); ?>" class="post__avatar">
                        <img src="<?php echo url_for($user->profileImage); ?>" alt="<?= $user->fullName; ?>"/>
                    </a>
                    <a href="<?php echo url_for($user->username); ?>" class="post__user">
                        <?php echo $user->username; ?>
                    </a>
               </div>
               <div class="postFormContainer">
                  <textarea id="postTextarea" class="outline-none resize-none h-32 sm:h-auto" placeholder="Write a caption..." name="caption" cols="40" rows="12"></textarea>
                  <div class="postButton">
                    <button id="post_button" class="cursor-pointer bg-primary-blue text-white px-6 py-1.5 rounded font-medium hover:drop-shadow-lg uppercase text-sm tracking-wider">Post</button>
                  </div>
               </div>
       </div>

    </div>

</div>
<!-------CREATE POST POPUP----->
