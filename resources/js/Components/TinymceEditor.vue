<script setup>
import Editor from '@tinymce/tinymce-vue'
import 'tinymce/icons/default/icons.min.js';
import 'tinymce/themes/silver/theme.min.js';
import 'tinymce/models/dom/model.min.js';
import '../tinymce/js/tinymce/langs/de.js';
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/table';
import 'tinymce/plugins/wordcount';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/save';
import 'tinymce/plugins/quickbars';
import 'tinymce/plugins/autoresize';

const content = defineModel();

const emits = defineEmits(['saveEditorContent', 'closeEditor'])

const save = () => {
    emits('saveEditorContent');
};

const cancel = () => {
    emits('closeEditor');
};

const editorConfig = {
    license_key: 'gpl',
    branding: false,
    min_height: 600,
    menu: {
        file: {title: 'File', items: 'print'},
    },
    plugins: 'advlist lists link image table wordcount fullscreen save quickbars autoresize',
    quickbars_selection_toolbar: 'bold italic underline strikethrough | bullist numlist | blockquote quicklink | h2 h3 h4 h5 h6 | outdent indent',
    toolbar: 'undo redo | styles | bold formatting | lists | alignment | fullscreen | outdent indent | save cancel',
    toolbar_groups: {
        formatting: {
            icon: 'format',
            tooltip: 'Formatierung',
            items: 'italic underline strikethrough superscript subscript | removeformat'
        },
        alignment: {
            icon: 'align-left',
            tooltip: 'Ausrichtung',
            items: 'alignleft aligncenter alignright alignjustify'
        },
        lists: {
            icon: 'unordered-list',
            tooltip: 'Liste',
            items: 'bullist numlist'
        },
    },
    toolbar_sticky: true,
    language: 'de',
    promotion: false,
    save_enablewhendirty: false,
    save_onsavecallback: () => {
        save();
    },
    save_oncancelcallback: () => {
        cancel();
    },
    content_css: false,
};

</script>

<template>
    <main>
        <Editor
            :init="editorConfig"
            v-model="content"
        />
    </main>
</template>

<style scoped>

</style>
