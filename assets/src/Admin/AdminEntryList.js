import React from "react";
import request from "request-promise";
import Entry from "../Wall/Entry";
import AdminEntryActions from "./AdminEntryActions";

class AdminEntryList extends React.Component {

    constructor(props) {
        super(props);
        this.state = {entries: [], isEmpty: false};
        this.onActionPerformed = this.onActionPerformed.bind(this);
    }

    onActionPerformed(entryId, actionName) {
        switch (actionName) {
            case 'approve':
                this.state.entries.some(function (entry, index, newEntries) {
                    if (entry.id === entryId) {
                        entry.is_approved = true;
                        newEntries[index] = entry;
                        this.setState({entries: newEntries});
                    }
                }.bind(this));
                break;
            case 'delete':
                const newEntries = this.state.entries.filter(function (entry) {
                    return entry.id !== entryId;
                });
                this.setState({entries: newEntries, isEmpty: (newEntries.length === 0)});
                break;
            default:
        }
    }

    componentDidMount() {
        const options = {
            method: 'GET',
            url: 'http://localhost:8001/api/entries',
            headers: {
                'Authorization': 'Bearer ' + JSON.parse(localStorage.token).access_token
            },
            json: true
        };
        request(options)
            .then(function (entries) {
                this.setState({entries: entries, isEmpty: (entries.length === 0)});
                return entries;
            }.bind(this))
            .catch(function (err) {

                this.setState({error: err.response.body.error});
            }.bind(this));
    }

    render() {
        const entriesComponents = this.state.entries.map(
            (entry) => <div key={entry.id}><Entry  {...entry}/>
                <AdminEntryActions onActionPerformed={this.onActionPerformed} {...entry} />
            </div>
        );

        const emptyListMsg = this.state.isEmpty && "The guestbook is empty.";

        return <div>
            <h3 className="text-primary">{emptyListMsg}</h3>
            <h3 className="text-danger error">{this.state.error}</h3>
            {entriesComponents}
        </div>
    }
}

export default AdminEntryList;