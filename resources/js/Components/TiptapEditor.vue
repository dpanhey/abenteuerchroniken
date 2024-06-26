<script setup>
import {useEditor, EditorContent} from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import {computed, ref, watch} from 'vue';
import {Markdown} from "tiptap-markdown";
import Link from '@tiptap/extension-link';
import 'remixicon/fonts/remixicon.css';
import Button from 'primevue/button';

const props = defineProps({
    modelValue: {
        type: String
    },
    isMenuActive: {
        type: Boolean,
        default: true
    },
    htmlContent: {
        type: String
    },
    isReadOnly: {
        type: Boolean
    }
});

const emit = defineEmits([
    'update:modelValue',
    'saveData'
]);

const isEditable = ref(false);

const makeEditable = () => {
    if (!props.isReadOnly) {
        isEditable.value = true;
        editor.value?.setOptions({editable: true});
    }
}

const save = () => {
    emit('update:modelValue', editor.value?.storage.markdown.getMarkdown());
    emit('saveData');
    isEditable.value = false;
    editor.value?.setOptions({editable: false});
}

const cancel = () => {
    editor.value?.commands.setContent(props.modelValue);
    isEditable.value = false;
    editor.value?.setOptions({editable: false});
}

const editorClasses = computed(() => {
    return props.isMenuActive
        ? 'min-h-[10rem] prose prose-sm max-w-none px-4 py-4 bg-surface-0 border-1 border-surface-300 rounded-b-lg border hover:border-primary transition duration-200 focus:outline-none focus:outline-offset-0 focus:ring-1 focus:ring-inset focus:ring-primary'
        : 'prose prose-sm max-w-none px-4 py-2 bg-surface-0 border-1 border-surface-300 rounded-lg border hover:border-primary transition duration-200 focus:outline-none focus:outline-offset-0 focus:ring-1 focus:ring-inset focus:ring-primary';
})

const tooltipData = computed(() => {
    return props.isReadOnly
    ? {  }
    : { value: 'Zum Bearbeiten klicken', showDelay: 500, hideDelay: 300 }
})

const editor = useEditor({
    extensions: [
        StarterKit.configure({
            heading: {
                levels: [2, 3, 4]
            },
            code: false,
            codeBlock: false,
        }),
        Link,
        Markdown
    ],
    content: props.modelValue,
    editorProps: {
        attributes: {
            class: editorClasses.value
        },
    },
    onUpdate: () => {
        emit('update:modelValue', editor.value?.storage.markdown.getMarkdown());
    }
});

const promptUserForHref = () => {
    // mit Dialog austauschen
    if (editor.value.isActive('link')) {
        return editor.value.chain().focus().unsetLink().run();
    }

    const href = prompt('Where do you want to link to?');

    if (!href) {
        return editor.value?.chain().focus().run();
    }

    return editor.value?.chain().focus().setLink({href}).run();
}

watch(() => props.modelValue, (value) => {
    if (value === editor.value?.storage.markdown.getMarkdown()) {
        return;
    }

    editor.value?.commands.setContent(value);
}, {immediate: true});

watch(() => props.htmlContent, (value) => {
    if (value === editor.value?.storage.markdown.getMarkdown()) {
        return;
    }

    editor.value?.commands.setContent(value);
}, {immediate: true});

</script>

<template>
    <div v-if="!isEditable"
         @click="makeEditable"
         class="bg-surface-0 rounded-lg"
         :class="props.isReadOnly ? 'hover:cursor-default' : 'hover:cursor-pointer'"
         v-tooltip.top="tooltipData">
        <div v-if="!htmlContent"
             class="py-2 px-4 prose prose-sm max-w-none bg-surface-0 rounded-lg"
             :class="isMenuActive ? 'min-h-[10rem]' : ''"
             v-html="props.modelValue"></div>
        <div v-else
             class="p-4 prose prose-sm max-w-none bg-surface-0 rounded-lg"
             v-html="htmlContent"></div>
    </div>
    <div v-else>
        <menu v-if="isMenuActive"
              class="flex bg-surface-0 divide-surface-200 divide-x border-1 border-surface-300 border rounded-t-lg text-base font-bold justify-between">
            <li class="flex w-full m-0">
                <button @click="editor.chain().focus().toggleBold().run()"
                        type="button"
                        class="w-full px-2 py-2 rounded-tl-lg"
                        :class="[editor.isActive('bold') ? 'bg-primary-500 text-surface-0' : 'hover:bg-surface-200']"
                        title="Bold">
                    <i class="ri-bold"></i>
                </button>
            </li>
            <li class="flex w-full m-0">
                <button @click="editor.chain().focus().toggleItalic().run()"
                        type="button"
                        class="w-full px-2 py-2"
                        :class="[editor.isActive('italic') ? 'bg-primary-500 text-surface-0' : 'hover:bg-surface-200']"
                        title="Italic">
                    <i class="ri-italic"></i>
                </button>
            </li>
            <li class="flex w-full m-0">
                <button @click="editor.chain().focus().toggleStrike().run()"
                        type="button"
                        class="w-full px-2 py-2"
                        :class="[editor.isActive('strike') ? 'bg-primary-500 text-surface-0' : 'hover:bg-surface-200']"
                        title="Strikethrough">
                    <i class="ri-strikethrough"></i>
                </button>
            </li>
            <li class="flex w-full m-0">
                <button @click="editor.chain().focus().toggleBlockquote().run()"
                        type="button"
                        class="w-full px-2 py-2"
                        :class="[editor.isActive('blockquote') ? 'bg-primary-500 text-surface-0' : 'hover:bg-surface-200']"
                        title="Blockquote">
                    <i class="ri-double-quotes-l"></i>
                </button>
            </li>
            <li class="flex w-full m-0">
                <button @click="editor.chain().focus().toggleBulletList().run()"
                        type="button"
                        class="w-full px-2 py-2"
                        :class="[editor.isActive('bulletList') ? 'bg-primary-500 text-surface-0' : 'hover:bg-surface-200']"
                        title="Bullet list">
                    <i class="ri-list-unordered"></i>
                </button>
            </li>
            <li class="flex w-full m-0">
                <button @click="editor.chain().focus().toggleOrderedList().run()"
                        type="button"
                        class="w-full px-2 py-2"
                        :class="[editor.isActive('orderedList') ? 'bg-primary-500 text-surface-0' : 'hover:bg-surface-200']"
                        title="Ordered list">
                    <i class="ri-list-ordered"></i>
                </button>
            </li>
            <li class="flex w-full m-0">
                <button @click="promptUserForHref"
                        type="button"
                        class="w-full px-2 py-2"
                        :class="[editor.isActive('link') ? 'bg-primary-500 text-surface-0' : 'hover:bg-surface-200']"
                        title="Add link">
                    <i class="ri-link"></i>
                </button>
            </li>
            <li class="flex w-full m-0">
                <button @click="editor.chain().focus().toggleHeading({ level: 2}).run()"
                        type="button"
                        class="w-full px-2 py-2"
                        :class="[editor.isActive('heading', { level: 2 }) ? 'bg-primary-500 text-surface-0' : 'hover:bg-surface-200']"
                        title="Heading 1">
                    <i class="ri-h-1"></i>
                </button>
            </li>
            <li class="flex w-full m-0">
                <button @click="editor.chain().focus().toggleHeading({ level: 3}).run()"
                        type="button"
                        class="w-full px-2 py-2"
                        :class="[editor.isActive('heading', { level: 3 }) ? 'bg-primary-500 text-surface-0' : 'hover:bg-surface-200']"
                        title="Heading 2">
                    <i class="ri-h-2"></i>
                </button>
            </li>
            <li class="flex w-full m-0">
                <button @click="editor.chain().focus().toggleHeading({ level: 4 }).run()"
                        type="button"
                        class="w-full px-2 py-2"
                        :class="[editor.isActive('heading', { level: 4 }) ? 'bg-primary-500 text-surface-0' : 'hover:bg-surface-200']"
                        title="Heading 3">
                    <i class="ri-h-3"></i>
                </button>
            </li>
        </menu>
        <EditorContent :editor="editor"/>
        <div class="flex justify-end gap-4 bg-surface-100 py-2">
            <Button label="Speichern"
                    icon="ri-save-line"
                    @click="save"/>
            <Button label="Abbrechen"
                    severity="secondary"
                    icon="ri-close-line"
                    @click="cancel"/>
        </div>
    </div>
</template>

<style scoped>

</style>
