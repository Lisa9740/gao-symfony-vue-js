import axios from 'axios';
export default {
    props: {
    },
    components: {
    },
    data() {
        return {
            name: '',
            dialog: false
        }
    },
    created() {
    },
    methods: {
        addComputer: function () {
            if (this.isValid()) {
                const data = {
                    name: this.name,
                };
                axios.post('/api/computers/create', data)
                    .then(({ data }) => {
                        this.$emit('add', data)
                        this.dialog = false
                    })
                    .catch(error => {
                        //TODO catch error
                        console.log(error);
                    });
            }

        },
        isValid() {
            return this.name !== ''
        }
    },
    computed: {
        validate() {
            return this.isValid()
        }
    }
}
