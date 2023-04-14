import axios from "axios";
import {useEffect, useState} from "react";
import { useNavigate } from "react-router-dom";

export default function CreateBookFormat() {
    const navigate = useNavigate();

    const [inputs, setInputs] = useState([]);

    const useValidation = (value, validations) => {
        const [isEmpty, setEmpty] = useState(true)
        const [minLengthError, setMinLengthError] = useState(false)
        const [maxLengthError, setMaxLengthError] = useState(false)
        const [inputValid, setInputValid] = useState(false)

        useEffect( () => {
            for (const validation in validations) {
                switch (validation) {
                    case 'minLength':
                        value.length < validations[validation] ? setMinLengthError(true) : setMinLengthError(false)
                        break;
                    case 'maxLength':
                        value.length > validations[validation] ? setMaxLengthError(true) : setMaxLengthError(false)
                        break;
                    case 'isEmpty':
                        value ? setEmpty(false): setEmpty(true)
                        break;
                }
            }
        }, [value, validations])

        useEffect( () => {
            if (isEmpty || maxLengthError || minLengthError) {
                setInputValid(false);
            } else {
                setInputValid(true);
            }
        }, [isEmpty, maxLengthError, minLengthError]);

        return {
            isEmpty,
            minLengthError,
            maxLengthError,
            inputValid
        }
    }

    const useInput = (initialValue, validations) => {
        const [value, setValue] = useState(initialValue)
        const [isDirty, setDirty] = useState(false)
        const valid = useValidation(value, validations)

        const onChange = (e) => {
            setValue(e.target.value)
            setInputs(values => ({...values, [e.target.name]: e.target.value}));
        }

        const onBlur = (e) => {
            setDirty(true)
        }

        return {
            value,
            onChange,
            onBlur,
            isDirty,
            ...valid
        }
    }

    const handleSubmit = (event) => {
        event.preventDefault();
        axios.post(process.env.REACT_APP_API_URL + '/book-format/create', inputs).then(function (response){
            console.log(response.data);
            navigate('/book-formats');
        });
    };

    const title = useInput('', { isEmpty: true, minLength: 4, maxLength: 50 });
    const size = useInput('', { isEmpty: true, minLength: 4, maxLength: 50 });

    return (
        <div className="row">
            <div className="col-3"></div>
            <div className="col-6">
                <h1>Create book format</h1>
                <form onSubmit={ handleSubmit }>
                    <div className="mb-3">
                        <label>Title</label>
                        <input value={ title.value } onChange={ e => title.onChange(e) } type="text" className="form-control" name="title"/>

                        <label>Size</label>
                        { (size.isDirty && size.isEmpty) && <div style={{ color: "red" }}>Поле не может быть пустым</div> }
                        { (size.isDirty && size.minLengthError) && <div style={{ color: "red" }}>Название должно быть длиннее 4 символов</div> }
                        { (size.isDirty && size.maxLengthError) && <div style={{ color: "red" }}>Название должно быть короче 50 символов</div> }
                        <input value={ size.value } onChange={ e => size.onChange(e) } onBlur={ e => size.onBlur(e) } type="text" className="form-control" name="size"/>

                    </div>
                    <button disabled={ !title.inputValid && !size.inputValid } type="submit" name="add" className="btn btn-primary">Save</button>
                </form>
            </div>
            <div className="col-3"></div>
        </div>
    )
}
