import AuthenticatedLayoutDrawer from "@/Layouts/AuthenticatedLayoutDrawer";
import { Link, router, useForm } from "@inertiajs/react";
import Pagination from "@mui/material/Pagination";
import {
    Box,
    Button,
    DialogActions,
    DialogContent,
    DialogTitle,
    List,
    ListItemButton,
    ListItemText,
    Stack,
    TextField,
    Typography,
} from "@mui/material";
import { useEffect, useState } from "react";
import Table from "@mui/material/Table";
import TableBody from "@mui/material/TableBody";
import TableCell from "@mui/material/TableCell";
import TableContainer from "@mui/material/TableContainer";
import TableHead from "@mui/material/TableHead";
import TableRow from "@mui/material/TableRow";
import Paper from "@mui/material/Paper";
import CustomDialog from "@/Components/CustomDialog";

const Show = ({ comments }: any) => {
    const [page, setPage] = useState(comments.current_page);
    const [openDialog, setOpenDialog] = useState(false);
    const form = useForm({
        email: "",
    });
    useEffect(() => {
        console.log("comments");
        console.log(comments);
    }, []);
    const commentForm = useForm({
        comment: "",
    });

    //!TODO: uhvatiti error za pogresni email i staviti autorizaciju na ceo sajt...npr samo admin da add user!

    /*   const sendComment = () => {
        commentForm.post(route("create.team.comment", team.id), {
            onSuccess: () => {
                console.log("success comment");
            },
            onError: (error: any) => {
                console.log("error", error);
            },
        });
    }; */
    return (
        <AuthenticatedLayoutDrawer>
            <Box>
                <div className="flex flex-col justify-center gap-5">
                    <h1 className="text-xl font-bold text-center ">Comments</h1>
                    <div className="flex flex-col gap-3">
                        {comments.data.map((comment: any) => {
                            return (
                                <div
                                    key={comment.id}
                                    className="w-full flex flex-row gap-3  border-[1px] p-1 border-black rounded-md"
                                >
                                    <div className="w-14 h-14 rounded-full bg-red-400 "></div>
                                    <div className="flex flex-col justify-center">
                                        <p>{comment.user.email}</p>
                                        <p>{comment.comment}</p>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>
                <Pagination
                    count={comments.last_page}
                    onChange={(e: any, value: any) => {
                        router.visit(comments.links[value].url);
                    }}
                    page={comments.current_page}
                />
            </Box>
        </AuthenticatedLayoutDrawer>
    );
};

export default Show;
