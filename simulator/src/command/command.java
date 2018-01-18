package command;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;

public class command {

    public static final String CHEMIN = "C:\\users\\Virgile\\desktop\\workspace\\";

    private static BufferedReader getOutput(Process p) {
        return new BufferedReader(new InputStreamReader(p.getInputStream()));
    }

    private static BufferedReader getError(Process p) {
        return new BufferedReader(new InputStreamReader(p.getErrorStream()));
    }

    public static void main(String[] args) {
        System.out.println("Début du programme");
        try {
            String[] commande = {"cmd.exe", "/C", CHEMIN + "HelloWorld.bat"};
            Process p = Runtime.getRuntime().exec(commande);
            BufferedReader output = getOutput(p);
            BufferedReader error = getError(p);
            String ligne = "";

            while ((ligne = output.readLine()) != null) {
                System.out.println(ligne);
            }
           
            while ((ligne = error.readLine()) != null) {
                System.out.println(ligne);
            }

            p.waitFor();
        } catch (IOException e) {
            e.printStackTrace();
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
        System.out.println("Fin du programme");
    }
}