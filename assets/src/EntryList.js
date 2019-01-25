import React from "react";
import request from "request-promise";
import Entry from "./Entry";

class EntryList extends React.Component {

    static defaultProps = {
        filter: 'is_approved',
        extraComponent: () => <div></div>,
    }

    constructor(props) {
        super(props);
        this.state = {entries: []}
    }

    componentDidMount() {
        const filter = this.props.filter;
        const options = {
            method: 'GET',
            url: 'http://localhost:8001/api/entries?XDEBUG_SESSION_START=PHPSTORM&' + (filter.length ? filter : ''),
            headers: {
                'Authorization': 'Bearer ' + JSON.parse(localStorage.token).access_token
            },
            json: true
        };
        request(options)
            .then(function (entries) {
                this.setState({entries: entries});
                return entries;
            }.bind(this))
            .catch(function (err) {

                this.setState({error: err.response.body.error});
            }.bind(this));
    }

    render() {
        const entriesComponents = this.state.entries.map(
            (entry) => <div key={entry.id}><Entry  {...entry}/>
                {this.props.extraComponent({id: "someid"})}
            </div>
        );
        return <div>
            <h2 className="text-danger error">{this.state.error}</h2>
            {entriesComponents}
            </div>
    }
}

export default EntryList;