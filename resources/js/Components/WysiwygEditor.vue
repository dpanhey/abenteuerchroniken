<script setup>
import 'ckeditor5/ckeditor5.css';
import translations from 'ckeditor5/translations/de.js';
import {
    ClassicEditor,
    AccessibilityHelp,
    Alignment,
    Autoformat,
    AutoLink,
    Autosave,
    BlockQuote,
    Bold,
    Essentials,
    FindAndReplace,
    Heading,
    HorizontalLine,
    HtmlComment,
    HtmlEmbed,
    Indent,
    IndentBlock,
    Italic,
    Link,
    List,
    Paragraph,
    SelectAll,
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableProperties,
    TableToolbar,
    TextPartLanguage,
    TextTransformation,
    Underline,
    Undo,
} from 'ckeditor5';

const content = defineModel();

const editorConfig = {
    toolbar: {
        items: [
            'undo',
            'redo',
            '|',
            'bold',
            'italic',
            'underline',
            '|',
            'heading',
            '|',
            'numberedList',
            'bulletedList',
            '|',
            'alignment',
            '|',
            'indent',
            'outdent',
            '|',
            'link',
            'insertTable',
            'blockQuote',
            '|',
        ],
        shouldNotGroupWhenFull: false
    },
    plugins: [
        AccessibilityHelp,
        Alignment,
        Autoformat,
        AutoLink,
        Autosave,
        BlockQuote,
        Bold,
        Essentials,
        FindAndReplace,
        Heading,
        HorizontalLine,
        HtmlComment,
        HtmlEmbed,
        Indent,
        IndentBlock,
        Italic,
        Link,
        List,
        Paragraph,
        SelectAll,
        Table,
        TableCaption,
        TableCellProperties,
        TableColumnResize,
        TableProperties,
        TableToolbar,
        TextPartLanguage,
        TextTransformation,
        Underline,
        Undo
    ],
    language: 'de',
    translations: [translations]
};
</script>

<template>
    <div class="prose prose-sm max-w-none">
        <ckeditor v-model="content"
                  :editor="ClassicEditor"
                  :config="editorConfig"/>
    </div>
</template>

<style scoped>

</style>
