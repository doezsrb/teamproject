import AuthenticatedLayoutDrawer from "@/Layouts/AuthenticatedLayoutDrawer";
import { useForm, usePage } from "@inertiajs/react";
import {
    Box,
    Button,
    CssBaseline,
    Stack,
    TextField,
    Typography,
} from "@mui/material";
import { useEffect } from "react";

const Create = () => {
    const { props }: any = usePage();
    useEffect(() => {
        console.log(props);
    }, []);
    const form = useForm({
        name: "",
        description: "",
        days: 1,
    });
    return (
        <AuthenticatedLayoutDrawer>
            <Box>
                <Typography variant="h5" align="center">
                    Create Project
                </Typography>
                <Stack>
                    <TextField
                        value={form.data.name}
                        onChange={(e: any) => {
                            form.setData("name", e.target.value);
                        }}
                        variant="outlined"
                        label="Project name"
                    />
                    <TextField
                        value={form.data.description}
                        onChange={(e: any) => {
                            form.setData("description", e.target.value);
                        }}
                        variant="outlined"
                        label="Project description"
                    />
                    <TextField
                        type="number"
                        value={form.data.days}
                        onChange={(e: any) => {
                            form.setData("days", e.target.value);
                        }}
                        variant="outlined"
                        label="Project days"
                    />
                    <Button
                        onClick={() => {
                            form.put(route("project.create", props.team_id), {
                                onSuccess: () => {
                                    console.log("success");
                                },
                                onError: (error) => {
                                    console.log(error);
                                },
                            });
                        }}
                    >
                        Create
                    </Button>
                </Stack>
            </Box>
        </AuthenticatedLayoutDrawer>
    );
};

export default Create;
