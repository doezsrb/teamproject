import CustomDialog from "@/Components/CustomDialog";
import Task from "@/Components/Task";
import TaskKanban from "@/Components/TaskKanban";
import AuthenticatedLayoutDrawer from "@/Layouts/AuthenticatedLayoutDrawer";
import { router, useForm } from "@inertiajs/react";
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

const Show = ({ project, tasks, comments }: any) => {
    const [openDialog, setOpenDialog] = useState(false);
    const commentForm = useForm({
        comment: "",
    });
    const taskForm = useForm({
        name: "",
        description: "",
        days: 1,
    });
    const sendComment = () => {
        commentForm.post(route("create.project.comment", project.id), {
            onSuccess: () => {
                console.log("success comment");
            },
            onError: (error: any) => {
                console.log("error", error);
            },
        });
    };
    //!TODO: uhvatiti error za pogresni email i staviti autorizaciju na ceo sajt...npr samo admin da add user!

    return (
        <AuthenticatedLayoutDrawer>
            <CustomDialog
                handleClose={() => {
                    setOpenDialog(false);
                }}
                open={openDialog}
            >
                <>
                    <DialogTitle>Create Task</DialogTitle>
                    <DialogContent sx={{ minWidth: 400 }}>
                        <Stack gap={3}>
                            <TextField
                                sx={{ width: "100%" }}
                                value={taskForm.data.name}
                                onChange={(e: any) => {
                                    taskForm.setData("name", e.target.value);
                                }}
                                variant="outlined"
                                label="Task name"
                            />
                            <TextField
                                sx={{ width: "100%" }}
                                value={taskForm.data.description}
                                onChange={(e: any) => {
                                    taskForm.setData(
                                        "description",
                                        e.target.value
                                    );
                                }}
                                variant="outlined"
                                label="Task description"
                            />
                            <TextField
                                sx={{ width: "100%" }}
                                value={taskForm.data.days}
                                onChange={(e: any) => {
                                    taskForm.setData("days", e.target.value);
                                }}
                                variant="outlined"
                                label="Task days"
                            />
                        </Stack>
                    </DialogContent>
                    <DialogActions>
                        <Button
                            onClick={() => {
                                setOpenDialog(false);
                            }}
                        >
                            Cancel
                        </Button>
                        <Button
                            onClick={() => {
                                taskForm.put(route("task.create", project.id), {
                                    onSuccess: () => {
                                        console.log("success");
                                    },
                                    onError: (error) => {
                                        console.log(error);
                                    },
                                });
                            }}
                            variant="contained"
                            color="inherit"
                        >
                            Create task
                        </Button>
                    </DialogActions>
                </>
            </CustomDialog>
            <Stack alignItems={"center"} gap={3}>
                <Typography variant="h3" align="center">
                    {project.name}
                </Typography>
                <Button
                    onClick={() => {
                        setOpenDialog(true);
                    }}
                    variant="contained"
                    color="inherit"
                >
                    CREATE TASK
                </Button>
                <Box sx={{ width: "100%" }}>
                    <Typography variant="h6" align="center">
                        Tasks
                    </Typography>
                    <TaskKanban
                        doneTasks={tasks.completed}
                        progressTasks={tasks.progress}
                        pendingTasks={tasks.pending}
                    />
                    {/* <List>
                        {tasks.map((task: any) => (
                            <ListItemButton key={task.id} onClick={() => {}}>
                                <ListItemText primary={task.name} />
                            </ListItemButton>
                        ))}
                    </List> */}
                </Box>
                <div className=" w-full flex flex-col justify-center gap-5">
                    <h1 className="text-xl font-bold text-center ">Comments</h1>
                    <div className="flex flex-col gap-3">
                        {comments.map((comment: any) => {
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

                    <textarea
                        className="rounded-md h-28"
                        value={commentForm.data.comment}
                        onChange={(e: any) => {
                            commentForm.setData("comment", e.target.value);
                        }}
                    />
                    <div className="w-full  flex flex-row ">
                        <div className="ml-auto">
                            <Button
                                onClick={sendComment}
                                variant="contained"
                                type="submit"
                            >
                                POST
                            </Button>
                        </div>
                    </div>
                </div>
            </Stack>
        </AuthenticatedLayoutDrawer>
    );
};

export default Show;
