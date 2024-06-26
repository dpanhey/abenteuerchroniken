<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PageHeading from "@/Components/PageHeading.vue";
import MainPanel from "@/Components/MainPanel.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <PageHeading>Dashboard</PageHeading>
        </template>

        <MainPanel>
            <div class="flex flex-col w-full items-center text-justify prose mx-auto">
                <h2 class="text-3xl font-semibold">Moin!</h2>
                <div class="text-lg">
                    <p>Hier findet ihr eine kleine Übersicht der aktuellen Funktionen.<br>Das "Design" (wenn man es denn so nennen kann...) ist natürlich noch nicht in Bearbeitung. Das Layout allerdings schon, falls euch also im Layout was auffällt, gerne ansprechen. Das gilt natürlich auch für alle anderen Bereiche. :)</p>
                    <p><span class="text-red-600 font-bold">Wichtig!</span> Nichts ist in Stein gemeißelt, bei allem gilt: <span class="italic">"subject to change"</span>.</p>
                </div>
                <div class="flex flex-col">
                    <div class="flex flex-col">
                        <h3 class="text-xl font-semibold underline underline-offset-4 pl-2">Abenteuer</h3>
                        <p>
                            Momentan können nur Abenteuer und zugehörige Funktionen genutzt werden. Klickt dafür einfach oben auf Abenteuer.
                            Dort findet ihr eine Auflistung aller öffentlich freigegebenen Abenteuer, darunter auch ein "Dummy"-Abenteuer, das zum Testen verwendet wird.
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <h4 class="text-lg font-semibold underline underline-offset-4 pl-2">Abenteuerübersicht</h4>
                        <p>
                            Sobald ihr auf "Abenteuer ansehen" klickt, kommt ihr auf die Übersichtsseite des Abenteuers.
                            Hier findet ihr alle groben Informationen zum Abenteuer, also den Titel, die Abenteuerbeschreibung und das Cover des Abenteuers.
                            Die Informationen die hier eingegeben werden, sollen in zukunft immer öffentlich einsehbar sein, damit andere Spieler einen Eindruck davon bekommen und z. B. passende Charaktere wählen.
                            Der Titel und die Beschreibung können bearbeitet werden. Im Fall der Beschreibung habt ihr ein paar Anpassungsmöglichkeiten, ähnlich zu Word (ohne den gesamten Umfang). Allerdings habt ihr hier keine unendliche Zeichenanzahl, da es nur als Kurzbeschreibung fungieren soll.
                        </p>
                        <h5 class="font-semibold underline underline-offset-4 pl-2">Seitennavigation</h5>
                        <p>
                            Auf der linken Seite der Abenteuerübersicht findet ihr eine kleine Seitennavigation.
                            Mit klick auf die "Übersicht" gelangt ihr immer zur Abenteuerbeschreibung.
                            Im Reiter Kapitel könnt ihr sehen, welche Kapitel im Abenteuer vorkommen und dort auch neue Kapitel anlegen.
                            Im Reiter Orte gilt dasselbe wie im Reiter Kapitel, nur für Orte. ;)
                            Die Seitennavigation ist ein Schlüsselelement, dass ich gerne auch für andere Bereiche der Seite nutzen würde. Hier freue ich mich besonders über Feedback! :)
                        </p>
                        <!--                        <ul class="pl-2">-->
                        <!--                            <li>1. Punkt</li>-->
                        <!--                            <li>2. Punkt</li>-->
                        <!--                            <li>3. Punkt</li>-->
                        <!--                        </ul>-->
                    </div>
                    <div class="flex flex-col">
                        <h4 class="text-lg font-semibold underline underline-offset-4 pl-2">Kapitel</h4>
                        <p>
                            Der Bereich Kapitel ist der Kernbereich jedes Abenteuers. Hier sollen alle Infos, Story, Geschehnisse etc. niedergeschrieben werden.
                            Titel und Beschreibung können hier genauso wie bei der Abenteuerübersicht angepasst werden. Die Beschränkung an Zeichen gilt für Kapitel natürlich nicht!
                            Wichtig: Die Kapitel sind ausschließlich an des jeweilige Abenteuer gebunden und können nicht für andere Abenteuer wiederverwendet werden.
                        </p>
<!--                        <ul class="pl-2">-->
<!--                            <li>1. Punkt</li>-->
<!--                            <li>2. Punkt</li>-->
<!--                            <li>3. Punkt</li>-->
<!--                        </ul>-->
                    </div>
                    <div class="flex flex-col">
                        <h4 class="text-lg font-semibold underline underline-offset-4 pl-2">Orte</h4>
                        <p>
                            Bei Orten ist das etwas anders als bei Kapiteln. Orte sind abenteuerunabhängig und können deshalb erstellt und jedem beliebigen Abenteuer hinzugefügt oder wieder entfernt werden.
                            Die Nutzung der Orte ist allerdings gleich zu denen der Kapitel oder der Abenteuerübersicht, es gibt einen Namen und eine Beschreibung die ohne Probleme angepasst werden kann.
                            Bisher können Orte aber nur im Abenteuerkontext erstellt, editiert, entfernt und gelöscht werden.
                        </p>
<!--                        <ul class="pl-2">-->
<!--                            <li>1. Punkt</li>-->
<!--                            <li>2. Punkt</li>-->
<!--                            <li>3. Punkt</li>-->
<!--                        </ul>-->
                    </div>
                </div>
            </div>
        </MainPanel>

    </AppLayout>
</template>
