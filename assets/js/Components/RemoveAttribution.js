import axios from 'axios';
import _ from 'lodash';
export default {
    props: {
        computer: {
            required: true
        },
        horaire: {
            required: true
        },
        attribution: {
            required: true
        },
    },
    data() {
        return {
            dialog: false,
        }
    },
    methods: {
        supprimer: function () {
            const data = {
                id: this.attribution.id,
            };
            axios.post('/api/attributions/remove', data)
                .then(({ data }) => {
                    this.$emit('removeAttribution', this.horaire)
                    this.dialog = false
                })
                .catch(error => {
                    //TODO catch error
                    console.log(error);
                });

        },
    }
}
