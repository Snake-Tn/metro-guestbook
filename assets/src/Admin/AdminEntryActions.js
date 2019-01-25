import React from "react";
import request from "request-promise";

class AdminEntryActions extends React.Component {

    constructor(props) {
        super(props);
        this.onApproveClick = this.onApproveClick.bind(this);
        this.onRemoveClick = this.onRemoveClick.bind(this);
        this.onEditClick = this.onEditClick.bind(this);
    }

    onApproveClick() {
        const options = {
            method: 'POST',
            url: 'http://localhost:8001/api/entries/' + this.props.id + '/is_approved',
            headers: {
                'Authorization': 'Bearer ' + JSON.parse(localStorage.token).access_token
            }
        };
        request(options)
            .then(function (res) {
                this.props.onActionPerformed(this.props.id, "approve");
            }.bind(this))
            .catch(function () {
            });
    };

    onRemoveClick() {
        const options = {
            method: 'DELETE',
            url: 'http://localhost:8001/api/entries/' + this.props.id,
            headers: {
                'Authorization': 'Bearer ' + JSON.parse(localStorage.token).access_token
            }
        };
        request(options)
            .then(function (res) {
                this.props.onActionPerformed(this.props.id, "delete");
            }.bind(this))
            .catch(function () {
            });
    }

    onEditClick() {
        //@TODO
    }

    render() {
        return <div className="admin-actions">
            <div className='raw'>
                {!this.props.is_approved && <button onClick={this.onApproveClick} type="button"
                                                    className="btn btn-outline-success btn-block">Approve
                </button>}
            </div>
            <div className='raw'>
                <button onClick={this.onRemoveClick} type="button" className="btn btn-outline-danger btn-block">Remove
                </button>
            </div>
            <div className='raw'>
                <button onClick={this.onEditClick} type="button" className="btn btn-outline-info btn-block">Edit
                </button>
            </div>
        </div>;
    }

}

export default AdminEntryActions;