import Editor from '@toast-ui/editor';
import '@toast-ui/editor/dist/i18n/ko-kr';
import '@toast-ui/editor/dist/toastui-editor.css';

const editor = new Editor({
    el: document.querySelector('#editor'),
    language: 'ko-KR',
    previewStyle: 'vertical',
    height: '500px',
    initialValue: '',
    hooks : {
        addImageBlobHook : function(e) {
            console.log(e);
        }
    }
});


