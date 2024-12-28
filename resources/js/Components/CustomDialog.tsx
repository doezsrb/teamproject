import DialogTitle from "@mui/material/DialogTitle";
import Dialog from "@mui/material/Dialog";
import {
    Button,
    DialogActions,
    DialogContent,
    Stack,
    TextField,
} from "@mui/material";
interface CustomDialogProps {
    children: any;
    handleClose: () => void;
    open: boolean;
}
const CustomDialog = ({ children, handleClose, open }: CustomDialogProps) => {
    return (
        <Dialog onClose={handleClose} open={open}>
            {children}
        </Dialog>
    );
};

export default CustomDialog;
