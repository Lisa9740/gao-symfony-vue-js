import AddAttribution from './AddAttribution.vue'
import RemoveAttribution from './RemoveAttribution'

export default {
    props: {
        computer: {
            required: true
        },
        date: {
            required: true
        },
    },
    watch: {
        ordinateur: function () {
            this.initialise();
        }
    },
    components: {
        AddAttribution,
        RemoveAttribution
    },
    data() {
        return {

            horaires: [],
            attributions: {}
        }
    },
    created() {
        this.initialise();
    },
    computed: {
    },
    methods : {
        initialise() {
            for (let i=0; i < this.computer.attributions.length; i++) {
                let attribution = this.computer.attributions[i]
                this.attributions[attribution.hour] = {
                    id: attribution.id,
                    name: attribution.customer,
                }
            }
            this.buildHoraires();
        },
        buildHoraires() {
            this.horaires = [];
            for (let i = 0; i < 10; i++) {
                this.horaires.push({
                    index: i + 8,
                    attribution: (typeof this.attributions[i + 8] !== 'undefined' ) ? this.attributions[i + 8] : false
                })
            }

        },
        addAttribution: function (attribution) {
            this.computer.attributions.push(attribution)
            this.initialise();
        },
        removeAttribution: function(horaire){
            _.unset(this.attributions,horaire)
            this.buildHoraires();
        }
    }
}
