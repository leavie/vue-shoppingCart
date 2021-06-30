// global component and new Vue instance mount on DOM
export default {
    template: `
    <div class="main-wrapper" v-show="isShow">
        <div class="dialogue-cover"></div>
        <div class="dialogue-frame" v-bind:class="{ 'center':isShow }">
            <div class="dialogue">
                <p class="title" v-text="title || 'Title'"></p>
                <p class="message" v-text="message || 'Message'"></p>
                <div class="action">
                    <p class="item emergency">
                        <button key="yes" v-text="yesText || 'Yes'"
                        v-on:click="confirm"></button>
                    </p>
                    <p class="item">
                        <button key="no"  v-text="noText || 'No'"
                        v-on:click="toggleModal"></button>
                    </p>
                </div>
            </div>
        </div>
    </div>
    `,
    name: 'modal-dialogue',
    props: ['title', 'message', 'yesText', 'noText'],
    // components: { RoundedButton },
    created() {
        this.$root.$on('request', this.prepare)
    },
    data() {
        return {
            isShow: false,
            task: undefined,
            target: undefined
        }
    },
    methods: {
        prepare(fn, item) {
            this.task = fn;
            this.target = item;
            this.toggleModal()
        },
        toggleModal() {
            this.isShow = !this.isShow
        },
        confirm() {
            this.task(this.target);
            this.toggleModal()
        }
    }
};