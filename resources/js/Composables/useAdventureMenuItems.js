import { ref, watch } from "vue";

export default function useAdventureMenuItems(adventure) {
    const adventureItems = ref([]);

    const generateMenuItems = (chapters, locations, adventureSlug) => [
        {
            label: 'Kapitel',
            items: [
                ...chapters.map((chapter) => ({
                    label: chapter.title,
                    route: `/abenteuer/${adventureSlug}/kapitel/${chapter.slug}`,
                })),
                {
                    label: 'Neues Kapitel erstellen',
                    type: 'createChapter',
                },
            ],
        },
        // {
        //     label: 'Charaktere',
        //     items: [
        //         ...newListItem.map((chapter) => ({
        //             label: chapter.title,
        //             route: `/abenteuer/${adventureSlug}/kapitel/${chapter.slug}`,
        //         })),
        //         {
        //             label: 'Neuen Charakter hinzufügen',
        //             type: 'createItem',
        //             route: `/abenteuer/${adventureSlug}/neues-kapitel`,
        //         },
        //     ],
        // },
        // {
        //     label: 'NPCs',
        //     items: [
        //         ...newListItem.map((chapter) => ({
        //             label: chapter.title,
        //             route: `/abenteuer/${adventureSlug}/kapitel/${chapter.slug}`,
        //         })),
        //         {
        //             label: 'Neuen NPC hinzufügen',
        //             type: 'createItem',
        //             route: `/abenteuer/${adventureSlug}/neues-kapitel`,
        //         },
        //     ],
        // },
        {
            label: 'Orte',
            items: [
                ...locations.map((location) => ({
                    label: location.name,
                    route: `/abenteuer/${adventureSlug}/ort/${location.slug}`,
                })),
                {
                    label: 'Neuen Ort erstellen',
                    type: 'createLocation',
                },
            ],
        },
    ];

    watch(
        () => [adventure.value?.chapters, adventure.value?.locations],
        ([newChapters, newLocations]) => {
            if (newChapters && newLocations) {
                adventureItems.value = generateMenuItems(newChapters, newLocations, adventure.value.slug);
            }
        },
        { immediate: true, deep: true }
    );

    return { adventureItems };
}
