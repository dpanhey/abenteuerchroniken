<script setup>
import Editor from '@tinymce/tinymce-vue'

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
        file: { title: 'File', items: 'print' },
    },
    plugins: 'advlist lists link image table help wordcount fullscreen save quickbars autoresize',
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
    }
};
// toolbar: [
//     { name: 'history', items: [ 'undo', 'redo' ] },
//     { name: 'styles', items: [ 'styles' ] },
//     { name: 'formatting', items: [ 'bold', 'italic' ] },
//     { name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ] },
//     { name: 'indentation', items: [ 'outdent', 'indent' ] },
//     { name: 'link', items: [ 'link', 'unlink' ] },
//     { name: 'insert', items: [ 'image', 'table', 'help' ] },
//     { name: 'tools', items: [ 'fullscreen' ] },
// ],
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
