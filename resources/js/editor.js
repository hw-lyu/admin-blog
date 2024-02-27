import Editor from '@toast-ui/editor';
import '@toast-ui/editor/dist/i18n/ko-kr';
import '@toast-ui/editor/dist/toastui-editor.css';

if (document?.querySelector('#editor')) {
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
                    url : '/api/v1/file/upload',
                    method : 'post',
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    data : formData,
                    auth: {
                        username: '',
                        password: ''
                    }
                }).then(function(res) {
                    let data = res.data,
                        imageSrc = document.getElementById('toastuiAltTextInput').value ?? 'image',
                        imageUrl = `![${imageSrc}](//lumii-photo.s3.ap-northeast-2.amazonaws.com/${data.data.file_path})`;

                    alert(data.msg);

                    document.querySelector('.toastui-editor-popup.toastui-editor-popup-add-image').style = "display:none;"

                    editor.insertText(imageUrl);
                }).catch(function(error) {
                    console.error(error);
                })
            }
        }
    });
}


