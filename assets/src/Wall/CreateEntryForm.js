import React from "react";
import request from "request-promise";

import {FilePond} from 'react-filepond';
import 'filepond/dist/filepond.min.css';

class CreateEntryForm extends React.Component {

    constructor(props) {
        super(props)
        this.state = {fileName: "Choose file", textContent: "", successMessage: ""}

        this.onTextContentChange = this.onTextContentChange.bind(this);
        this.onEntryPosted = this.onEntryPosted.bind(this);
        this.onPostButtonClick = this.onPostButtonClick.bind(this);
    }


    onTextContentChange(event) {
        this.setState({textContent: event.target.value});
    }

    onEntryPosted() {
        this.setState({
            textContent: "",
            successMessage: "Entry is written successfully to the guestbook ! it will be visible here after we review it."
        })
    }

    onPostButtonClick() {
        const textContent = this.state.textContent;
        const options = {
            method: 'POST',
            body: {
                type: 'text',
                content: textContent,
            },
            url: 'http://localhost:8001/api/entries',
            headers: {
                'Authorization': 'Bearer ' + JSON.parse(localStorage.token).access_token
            },
            json: true
        };
        request(options)
            .then(function (res) {
                this.onEntryPosted();
            }.bind(this))
            .catch(function () {
            });
    }

    render() {
        return (
            <div className="create-entry-form">
                <div className="create-entry-form-title">Create Entry</div>
                <form>
                    <div className="form-group">
                        <textarea onChange={this.onTextContentChange} className="form-control"
                                  id="exampleFormControlTextarea1" rows="3" value={this.state.textContent}></textarea>
                    </div>
                </form>
                <button onClick={this.onPostButtonClick} type="button"
                        className="post-entry btn btn-secondary btn-lg btn-block">Post
                </button>
                <div className="row">
                    <div className="or">Or upload an image</div>
                </div>
                <FilePond onupdatefiles={this.onEntryPosted} name="entry"
                          labelIdle="Drag & Drop your image or <span class='filepond--label-action'> Browse </span>"
                          server=
                              {
                                  {
                                      url: 'http://localhost:8001/api/entries',
                                      revert: null,
                                      process: {
                                          method: 'POST',
                                          withCredentials: false,
                                          headers: {
                                              Authorization: 'Bearer ' + JSON.parse(localStorage.token).access_token
                                          },
                                          timeout: 7000,
                                          onload: null,
                                          onerror: null,
                                          ondata: null
                                      }
                                  }
                              }>
                </FilePond>

                <div className="success-msg">{this.state.successMessage}</div>
            </div>
        );
    }
}

export default CreateEntryForm;