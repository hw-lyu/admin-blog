import Editor from '@toast-ui/editor';
import '@toast-ui/editor/dist/i18n/ko-kr';
import '@toast-ui/editor/dist/toastui-editor.css';

if (document?.querySelector('#editor')) {
    let forms = document.forms, content = document.querySelector('textarea[name="content"]');
    const editor = new Editor({
        el: document.querySelector('#editor'),
        language: 'ko-KR',
        previewStyle: 'vertical',
        height: '500px',
        initialValue: '',
        hooks: {
            addImageBlobHook: function (e) {
                let formData = new FormData();
                formData.append('post_img', e);

                axios({
                    url: '/api/v1/file/upload', method: 'post', headers: {
                        "Content-Type": "multipart/form-data",
                    }, data: formData, auth: {
                        username: 't', password: 't'
                    }
                }).then(function (res) {
                    let data = res.data, imageSrc = document.getElementById('toastuiAltTextInput').value ?? 'image',
                        imageUrl = `![${imageSrc}](//lumii-photo.s3.ap-northeast-2.amazonaws.com/${data.post.post_path}?id=${data.post.id})`;

                    alert(data.msg);

                    document.querySelector('.toastui-editor-popup.toastui-editor-popup-add-image').style = "display:none;"

                    editor.insertText(imageUrl);
                }).catch(function (error) {
                    console.error(error);
                })
            }
        }
    });

    if (content) {
        editor.setHTML(content.value);
    }

    if (forms.write_form) {
        forms.write_form.addEventListener('submit', function (e) {
            e.preventDefault();

            let hiddenTag = document.querySelector('.hidden-tag'),
                url = hiddenTag.querySelector('img')?.src ?? '';

            this.querySelector('textarea[name="content"]').value = editor.getHTML();
            hiddenTag.innerHTML = this.querySelector('textarea[name="content"]').value;

            if(url) {
                let searchParams = new URL(url).searchParams,
                    imgId = -1;

                for (const param of searchParams) {
                    if (param[0] === 'id') {
                        imgId = parseInt(param[1]);
                    }
                }

                this.querySelector('input[name="thumbnail_id"]').value = imgId === -1 ? '' : imgId;
            }

            this.submit();
        });
    }

    if (forms.send_form) {
        document.forms.send_form.addEventListener('click', function (e) {
            let eTarget = e.target, btnObj = {
                'destroy': {
                    'method': 'POST', 'action': document.querySelector('input[name="destroy_action"]').value
                }, 'update': {
                    'method': 'POST', 'action': document.querySelector('input[name="update_action"]').value
                }
            }, method = document.querySelector('input[name="_method"]');

            this.querySelector('textarea[name="content"]').value = editor.getHTML();

            let hiddenTag = document.querySelector('.hidden-tag'),
                url = hiddenTag.querySelector('img')?.src ?? '';

            hiddenTag.innerHTML = this.querySelector('textarea[name="content"]').value;

            if(url) {
                let searchParams = new URL(url).searchParams,
                    imgId = -1;

                for (const param of searchParams) {
                    if (param[0] === 'id') {
                        imgId = parseInt(param[1]);
                    }
                }

                this.querySelector('input[name="thumbnail_id"]').value = imgId === -1 ? '' : imgId;
            }

            if (eTarget.classList.contains('btn-destroy')) {
                this.method = btnObj.destroy.method;
                this.action = btnObj.destroy.action;
                method.value = "DELETE";
                this.submit();
            }

            if (eTarget.classList.contains('btn-update')) {
                this.method = btnObj.update.method;
                this.action = btnObj.update.action;
                method.value = "PATCH";
                this.submit();
            }
        });
    }
}

if (document?.querySelector('#viewer')) {
    const viewer = Editor.factory({
        el: document.querySelector('#viewer'),
        viewer: true,
        height: '600px',
        initialValue: document.querySelector('textarea[name="content"]').value
    });
}


