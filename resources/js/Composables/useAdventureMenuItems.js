import { ref, watch } from "vue";

export default function useAdventureMenuItems(adventure) {
    const adventureItems = ref([]);

    const generateMenuItems = (chapters, enemies, locations, nonplayercharacters, adventureSlug) => [
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
        {
            label: 'NSCs',
            items: [
                ...nonplayercharacters.map((nonplayercharacter) => ({
                    label: nonplayercharacter.name,
                    route: `/abenteuer/${adventureSlug}/nsc/${nonplayercharacter.slug}`,
                })),
                {
                    label: 'Neuen NSC erstellen',
                    type: 'createNonPlayerCharacter',
                },
            ],
        },
        {
            label: 'Gegner',
            items: [
                ...enemies.map((enemy) => ({
                    label: enemy.name,
                    route: `/abenteuer/${adventureSlug}/gegner/${enemy.slug}`,
                })),
                {
                    label: 'Neuen Gegner erstellen',
                    type: 'createEnemy',
                },
            ],
        },
    ];

    watch(
        () => [adventure.value?.chapters, adventure.value?.enemies, adventure.value?.locations, adventure.value?.nonplayercharacters],
        ([newChapters, newEnemies, newLocations, newNonPlayerCharacters]) => {
            if (newChapters || newEnemies || newLocations || newNonPlayerCharacters) {
                adventureItems.value = generateMenuItems(newChapters? newChapters : [], newEnemies? newEnemies : [], newLocations? newLocations : [], newNonPlayerCharacters? newNonPlayerCharacters : [], adventure.value.slug);
            }
        },
        { immediate: true, deep: true }
    );

    return { adventureItems };
}
